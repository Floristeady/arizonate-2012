<?
   function getAttribute($attrib, $tag){
      //get attribute from html tag
      $re = '/' . preg_quote($attrib) . '=([\'"])?((?(1).+?|[^\s>]+))(?(1)\1)/is';
      if (preg_match($re, $tag, $match)) {
         return urldecode($match[2]);
      }
      return false;
   }
   
	function filter_field($str) {

			if (get_configuration_param("html_filter_on")) {
				
				if (strlen(get_configuration_param("html_filter_spec"))>0)
					$spec = get_configuration_param("html_filter_spec");
				else
					$spec = 'span=*,style(nomatch="/font/i"); p,pre,h1,h2,h3,h4,h5=*,-style, class(noneof=MsoNormal)';

				$str= htmLawed::filter($str, array(
					"clean_ms_char" => 1, 
					"comment" => 1, 
					"cdata" => 0, 
					"tidy" => -1
				), 
				$spec);
				$remove = array("<p></p>");
				$str = str_replace($remove, "", $str);
				
			}
			
			/*
				SIEMPRE SIN IMPORTAR EL valor de html_filter_on
				TODO: Filtrar html de imagenes
				ESTE CODIGO ESTA EN BETA

				FILTRAR SOLO: \/portalpad\/index.php\/main\/image_fetch\/xxx.jpg a /images/{WIDTH}/xxx.jpg
				
				EL SIGUIENTE FILTRO ESTA EN DESUSO:
					$p = array("/(<img.*?).*?src=\"\/site\/portalpad_upload\/(.*)\" .*? width=\"(.*?)\".*?(.*?>)/");
					$r = '$1 src="/frontbase/fetch_image.php?file_name=$2&width=$3" $4';
					$str = preg_replace($p, $r,$str);
				*/
				$p = array("/(<img.*?).*?src=\"\/portalpad\/index.php\/main\/image_fetch\/(.*)\" .*? width=\"(.*?)\".*?(.*?>)/");
				$r = '$1 src="/assets/images/$3/$2" width="$3" $4';
				$str = preg_replace($p, $r,$str);
				
				// para imagenes sin width
				$p = array("/(<img.*?).*?src=\"\/portalpad\/index.php\/main\/image_fetch\/(.*)\" .*?\".*?(.*?>)/");
				$r = '$1 src="/assets/images/$2" ';
				$str = preg_replace($p, $r,$str);
	
			
			
			return $str;
	
	}