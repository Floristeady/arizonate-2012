<?

class PortalDataFile {
		function PortalDataFile($filename, $has_attachment_settings, $original_filename = null) {
			$this->parent_path = $has_attachment_settings["path"];
			$this->model = $has_attachment_settings["model"];
			$this->model_id = $has_attachment_settings["model_id"];
			$this->field = $has_attachment_settings["field"];

			$this->filename = $filename;
			if (strlen($original_filename)>0)
				$this->original_filename = $original_filename;
			else
				$this->original_filename = $this->filename;
		}
		function getFileName() {
			return $this->filename;
		}
		function getPath(){
			return $this->parent_path.$this->filename;
		}
		function getExtension() {
			return strtolower(substr(strrchr($this->filename, '.'), 1));
		}
		function getFileSize($readable = false) {
			$fl = $this->getPath();
			if (isset($fl)) {
				if (file_exists($_SERVER["DOCUMENT_ROOT"].$fl)) {
					$filesize = filesize($_SERVER["DOCUMENT_ROOT"].$fl);
					if ($readable)
						return round($filesize/1024)."kb";
					else
						return $filesize;
				} else {
					return "";
				}
			}
			else {
				return "";
			}
		}
		function isImage() {
			if (in_array($this->getExtension(), array("png", "bmp", "jpeg", "jpg","gif"))) {
				return true;	
			}
			else {
				return false;	
			}
		}	
		function isVertical() {
			/* todo: pasar a subclase con herencia */		
			if ($image = $this->getImage()) {
				if (imagesx($image) < imagesy($image))
					return true;
				else
					return false;
			}
			else {
				return false;	
			}
		}
		function getImage() {
        $entension = strtolower($this->getExtension());
        if ($entension == "jpg") {
        	return imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"].$this->getPath());
        }
        elseif ($entension == "gif") {
        	return imagecreatefromgif($_SERVER["DOCUMENT_ROOT"].$this->getPath());
        }
        elseif ($entension == "png") {
        	return imagecreatefrompng($_SERVER["DOCUMENT_ROOT"].$this->getPath());
        }
        elseif ($entension == "bmp") {
        	return imagecreatefrombmp($_SERVER["DOCUMENT_ROOT"].$this->getPath());
        }
        else {
        	return false;
        }
			
		}
		function getLink($width = 100, $height = null) {
			/*
				TODO: Usar default controller y opcion para usar otro controller
			*/
			//product/5/images/file/
			if ($this->isImage()) {
				if (is_null($height))
					return "/assets/models/".strtolower($this->model)."/".$this->model_id."/images/".$this->field."/".$width;
				else
					return "/assets/models/".strtolower($this->model)."/".$this->model_id."/images/".$this->field."/".$width."/".$height;
			}
		}
		function read() {
			readfile($_SERVER["DOCUMENT_ROOT"].$this->getPath());	
		}
		function output_as_browser_attachment() {
			header('Content-type: application/'.$this->getExtension());
			header('Content-Disposition: attachment; filename="'.$this->original_filename.'"');
			// fix para MsOffice+IE+SSL
			header('Cache-Control: ');
			header('Pragma: ');
			$this->read();
			exit();
		}
		function  __toString() {
			return $this->getPath();
		}
	}