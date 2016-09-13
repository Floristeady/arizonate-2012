<?
	abstract class PFile{
		// TODO: customizacion de controllers y rutas
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
		function getPath() {
			/*
				Ruta fisica al archivo (esta ruta inaccesible desde el servidor web)
			*/
			return "/site/portalpad_upload/".$this->file_name;
		}
		function getDownloadLink() {
			// Detecta si se trata de un archivo atachado como 1-to-MANY a un content
			if ($this->content_id > 0) {
				// TODO: customizacion de controllers y rutas
				return url_for("file","download",$this->id);
			}
			
		}
		function getExtension() {
			return strtolower(substr(strrchr($this->file_name, '.'), 1));
		}
	}