<?

class AttachmentHelper {

	function display_attachment($model_object, $property) {
		/* OPCIONES necesarias:
		 link_to
		rel="shadowbox"
		diplsya original_filename or name
		msg for "no file"		
		*/
		$str = "";
		if (is_object($model_object->$property)) {
			if ($model_object->$property->isImage()) {
					$tag = new TagHelper("img");
					$tag->addAt("src",$model_object->$property->getLink());
					$tag->addAt("width",100);
					if ($option["shadowbox"] == true) {
						$tag->addAt("rel","shadowbox");
						$tag->addAt("href",$model_object->$property->getLink(600));
					}
					$str .= $tag->output();
			}
			$str .= "<p class='file_details'>";
			$str .= "<a target='_blank' href='".$model_object->$property->getPath()."'>";
			
			$str .= $model_object->$property->filename." (".$model_object->$property->getFileSize(true).")";
			$str .= "</a>";
			$str .= "</p>";
			
			
		}
		else {
			$str.= "";	
		}
		return $str;
	}
}