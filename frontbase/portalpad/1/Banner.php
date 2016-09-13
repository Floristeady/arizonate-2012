<?
	class Banner {
		function Banner($width = 944, $height = 168) {
			$this->banners_path = "/site/banners";
			$this->default = "default.swf";
			$this->width = $width;
			$this->height = $height;
			$this->wmode = "transparent";
		}
		function resolve() {
			$this->banners_path = "/site/banners";
			if (isset($this->content)) {
				if (get_current_lang() != get_default_lang()) {
					$check_path = $this->banners_path.get_url_base()."/contents/".$this->content->id.".swf";
					if (file_exists($_SERVER["DOCUMENT_ROOT"].$check_path)) {
						$this->path = $check_path;
						$this->type = "swf";
						return true;
					}
					$check_path = $this->banners_path.get_url_base()."/contents/".$this->content->id.".jpg";
					if (file_exists($_SERVER["DOCUMENT_ROOT"].$check_path)) {
						$this->path = $check_path;
						$this->type = "jpg";
						return true;
					}
				}
				
				
				$check_path = $this->banners_path."/contents/".$this->content->id.".swf";
				if (file_exists($_SERVER["DOCUMENT_ROOT"].$check_path)) {
					$this->path = $check_path;
					$this->type = "swf";
					return true;
				}
				$check_path = $this->banners_path."/contents/".$this->content->id.".jpg";
				if (file_exists($_SERVER["DOCUMENT_ROOT"].$check_path)) {
					$this->path = $check_path;
					$this->type = "jpg";
					return true;
				}
			}
			// then check if something for section
			if (isset($this->section)) {
				
				if (get_current_lang() != get_default_lang()) {
					
					$check_path = $this->banners_path.get_url_base()."/sections/".$this->section->id.".swf";
					
					if (file_exists($_SERVER["DOCUMENT_ROOT"].$check_path)) {
						$this->path = $check_path;
						$this->type = "swf";
						return true;
					}
					$check_path = $this->banners_path.get_url_base()."/sections/".$this->section->id.".jpg";
					
					if (file_exists($_SERVER["DOCUMENT_ROOT"].$check_path)) {
						$this->path = $check_path;
						$this->type = "jpg";
						return true;
					}
				}
				
				$check_path = $this->banners_path."/sections/".$this->section->id.".swf";
				if (file_exists($_SERVER["DOCUMENT_ROOT"].$check_path)) {
					$this->path = $check_path;
					$this->type = "swf";
					return true;
				}
				$check_path = $this->banners_path."/sections/".$this->section->id.".jpg";
				if (file_exists($_SERVER["DOCUMENT_ROOT"].$check_path)) {
					$this->path = $check_path;
					$this->type = "jpg";
					return true;
				}

			}
			// then check if something for parent
			if (isset($this->section->parent)) {
				if (get_current_lang() != get_default_lang()) {
					$check_path = $this->banners_path.get_url_base()."/sections/".$this->section->parent->id.".swf";
					if (file_exists($_SERVER["DOCUMENT_ROOT"].$check_path)) {
						$this->path = $check_path;
						$this->type = "swf";
						return true;
					}
					$check_path = $this->banners_path.get_url_base()."/sections/".$this->section->parent->id.".jpg";
					if (file_exists($_SERVER["DOCUMENT_ROOT"].$check_path)) {
						$this->path = $check_path;
						$this->type = "jpg";
						return true;
					}
				}
				$check_path = $this->banners_path."/sections/".$this->section->parent->id.".swf";
				if (file_exists($_SERVER["DOCUMENT_ROOT"].$check_path)) {
					$this->path = $check_path;
					$this->type = "swf";
					return true;
				}
				$check_path = $this->banners_path."/sections/".$this->section->parent->id.".jpg";
				if (file_exists($_SERVER["DOCUMENT_ROOT"].$check_path)) {
					$this->path = $check_path;
					$this->type = "jpg";
					return true;
				}
			}
			// then check if there's something for the default banner
			
			if (get_current_lang() != get_default_lang()) {
				$check_path = $this->banners_path.get_url_base()."/default.swf";
				if (file_exists($_SERVER["DOCUMENT_ROOT"].$check_path)) {
					$this->path = $check_path;
					$this->type = "swf";
					return true;
				}
				$check_path = $this->banners_path.get_url_base()."/default.jpg";
				if (file_exists($_SERVER["DOCUMENT_ROOT"].$check_path)) {
					$this->path = $check_path;
					$this->type = "jpg";
					return true;
				}
			}
			
			
			$check_path = $this->banners_path."/default.swf";
			if (file_exists($_SERVER["DOCUMENT_ROOT"].$check_path)) {
				$this->path = $check_path;
				$this->type = "swf";
				return true;
			}
			// then check if there's something for the default banner
			$check_path = $this->banners_path."/default.jpg";
			if (file_exists($_SERVER["DOCUMENT_ROOT"].$check_path)) {
				$this->path = $check_path;
				$this->type = "jpg";
				return true;
			}
			
			
			return false;
		}
		function output() {
			if (!$this->resolve()) {
				$this->path = $this->banners_path.get_url_base()."/".$this->default;
				$this->type = "swf";
			}
			
			if ($this->type == "jpg") {
				echo "<img src='".$this->path."' width='".$this->width."' height='".$this->height."' >"; 
			}
			if ($this->type == "swf") {
				// Only works with SWFOBject v1.5!
				echo "<div id=\"main_banner\"></div>\n";
				echo "<script>\n";
				echo "var so = new SWFObject('".$this->path."', 'mymovie', '".$this->width."', '".$this->height."', '8', '#336699');\n";
				if ($this->wmode)
					echo "so.addParam('wmode', '".$this->wmode."');\n";
				echo "so.addParam('menu', 'false');\n";
				echo "so.write('main_banner');\n";
				echo "</script>\n"; 
			}
			
		}
	}