<?

	class PImage extends PFile{

		function getItemLink($width = 40, $height = null) {
			/*
				TODO: Usar default controller y opcion para usar otro controller
			*/
			if (get_configuration_param("friendly_urls")) {
				if ($width > 0) {
					if ($height > 0) {
						return "/assets/images/".$width."/".$height."/".$this->file_name;
					}
					else {
						return "/assets/images/".$width."/".$this->file_name;
					}
				}
				else
					return "/assets/images/100/".$this->file_name;
			}
			else {
				if ($width > 0)
					return url_for("_portalpad_image", "get_resized", array( $this->file_name,$width));
				else
					return url_for("_portalpad_image", "get_resized", array( $this->file_name,100));
			}
		}	

	}