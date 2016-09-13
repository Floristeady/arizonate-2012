<?

	class URLMapper {

		function URLMapper($url,$routes) {
			$this->found = false;
			/*
				TODO: REVISAR RUTAS ESPECIFICAS PARA CADA IDIOMA
			*/
			if ($routes) {
				foreach($routes as $route) {
					if ($route[0] == $url) {
						$this->controller = $route[1];
						$this->action = $route[2];
						$this->args = $route[3];
						$this->found = true;
					}
				}
			}
			
		}

	}