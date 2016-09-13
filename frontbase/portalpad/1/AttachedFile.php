<?

	class AttachedFile extends PFile{
		function getItemLink($force_download = true) {
			/*
				Ruta publica al archivo
				RewriteRule ^assets/files/(.*)$ _file/get_from_filename/$1 [L,QSA]
				TODO: posibilidad de customizar controlador para esta accion
			*/
			return "/assets/files/".$this->file_name;
		}
		function getPublicName() {
			if (strlen($this->description)>0)
				return $this->description;
			elseif (strlen($this->original_name)>0) 
				return $this->original_name;
			else
				return $this->file_name;
		}
	}