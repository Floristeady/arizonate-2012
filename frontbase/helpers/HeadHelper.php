<?


function sort_scripts($a, $b)
{
    if ($a["priority"] == $b["priority"]) {
        return 0;
    }
    return ($a["priority"] > $b["priority"]) ? -1 : 1;
}


   class HeadHelper {
			function HeadHelper($page = null) {
				$this->metatags = array();
				$this->tags = array();
				$this->css = array();
				$this->scripts = array();
				$this->embed_scripts = array();
				if (not_empty(get_configuration_param("charset"))) {
					$this->setCharset(get_configuration_param("charset"));
				}
				else {
					$this->setCharset();
				}
				if (get_configuration_param("robots_index") == false && get_env() != "production") {
					$this->metatags[] = new Metatag(array("NAME" => "ROBOTS", "CONTENT" => "NOINDEX, NOFOLLOW"));
				}
			}
			function addMetaTag($name, $attributes) {
				$this->metatags[$name] = new Metatag($attributes);
			}
			function setCharset($charset = "iso-8859-1") {
				$this->metatags["charset"] = new Metatag(array("http-equiv" => "Content-Type", "content" => "text/html;charset=".$charset ));
			}
			function setFavIcon($path = "/favicon.ico") {
				// GOTCHA usar .ico para IE 7 poner "shortcut icon" y *no* "icon shortcut"
				// GOTCHA usar IcoFX para crear los íconos
				$this->tags["charset"] = new TagHelper("link", array("rel" => "shortcut icon", "href" => $path));
	
			}
			
			function addcss($path = "/css/style.css", $media = "all") {
				if (file_exists($_SERVER["DOCUMENT_ROOT"].$path)) {
					if (!in_array($path, $this->css))
						$this->css[] = array("path" => $path, "media" => $media);
					else
						return false;
				}
				else {
					if (get_env() != "production") {
						die("CSS on ".$path." was not found");
					}
				}
			}
			function addEmbedScript($script) {
				$this->embed_scripts[] = $script;
			}
			function addscript($path, $force = false, $priority = NORMAL_PRIORITY) {
				if (substr($path,0,7) == "http://" || $force || file_exists($_SERVER["DOCUMENT_ROOT"].$path)) {
					
					foreach ($this->scripts as $script) {
						if ($path == $script["path"]) {
							return false;
						}	
					} 
					$this->scripts[] = array("path" => $path, "priority" => $priority);

				}
				else {
					if (get_env() != "production") {
						die("Script on ".$path." was not found");
					}
				}
			}
			function addDocumentEvent($event, $code) {
				$this->events[$event] = $this->events[$event].$code;
			}
			
			function output($put_heads = true) {
				if ($put_heads)
					echo "<head>\n";
				if (isset($this->title))
					echo "<title>".$this->title."</title>\n";
				foreach ($this->metatags as $metatag) {
					echo $metatag->output()."\n";
				}
				foreach ($this->tags as $tag) {
					echo $tag->output()."\n";
				}
				usort($this->scripts, "sort_scripts");
				
				if (get_configuration_param("minify")) {
					/*
					TODO: support for media!!
					busca algun css/syle.css y lo mueve al inicio del array, para respetar los @import		
					$f = create_function('$a', '$a = preg_replace("/^\//", "", $a);if($a == "css/style.css") {return false;} else {return true;} ');
					if (count($paths_to_minify) != count(array_filter($paths_to_minify,$f))) {
						$paths_to_minify = array_filter($paths_to_minify,$f);
						array_unshift($paths_to_minify, "css/style.css");
					}
					*/
					$paths_to_minify = array();
					foreach ($this->css as $css) {
						$paths_to_minify[] = $css["path"];
					}
					echo '<link type="text/css" rel="stylesheet" href="/min/f='.implode(",",$paths_to_minify).'" />';
				} else {
					foreach ($this->css as $css) {
						echo "<link href=\"".$css["path"]."\" media=\"".$css["media"]."\" rel=\"stylesheet\" type=\"text/css\" >\n";
					}
				}
				
				
				if (get_configuration_param("minify")) {
					$js_to_minify = array();
					foreach ($this->scripts as $key => $script) {
						if (substr($script["path"],0,7) != "http://") {
							$js_to_minify[] = $script["path"];
							unset($this->scripts[$key]);
						}
					}

					echo "<script type=\"text/javascript\" src=\"/min/f=".implode(",",$js_to_minify)."\"></script>\n";
					
					foreach ($this->scripts as $script) {
						echo "<script type=\"text/javascript\" src=\"".$script["path"]."\"></script>\n";
					}
				}
				else {
					foreach ($this->scripts as $script) {
						echo "<script type=\"text/javascript\" src=\"".$script["path"]."\"></script>\n";
					}
				}
				
				if (not_empty($this->embed_scripts)) {
					echo "<script>";
					foreach ($this->embed_scripts as $script) {
						echo $script."\n";
					}
					echo "</script>";
				}
				
				if (not_empty($this->events["ready"])) {
					$str = "<script>
						$(document).ready(function(){";
					$str .= $this->events["ready"];
					
					$str .= "});
					</script>
					";
					echo $str;
				}
				
				if ($put_heads) {
					echo "</head>\n";
				}
			}
	
	}