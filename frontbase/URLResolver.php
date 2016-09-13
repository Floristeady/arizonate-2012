<?
	class URLResolver {
		
		function resolve($requested_uri) {
			global $default_controller;
			global $langs;
			global $url_spaces;
			if (isset($requested_uri)) {
				$page_file = null;
				$url_parts = explode("/",$requested_uri);
				$args = array();
				$this->lang = get_default_lang();
				$url_base = "";

				
				if (isset($url_spaces)) {
					if (isset($url_spaces[$url_parts[0]])) {
						$this->current_site = $url_spaces[$url_parts[0]];
						$url_parts = array_slice($url_parts, 1);
					}
				}
				if (is_array($langs) && in_array($url_parts[0],$langs)) {
					$this->lang = $url_parts[0];
					$url_parts = array_slice($url_parts, 1);
					
					// Obtener el URL sin la parte idiomatica
					$neutral_uri = implode("/", $url_parts);
				}
				else {
					$neutral_uri = $requested_uri;
				}
				if (strlen($url_parts[0]) == 0) {
					/*
						ES LA PAGINA PRINCIPAL DE UN IDIOMA
					*/
					$this->controller = $default_controller;
					$this->action = "index";
				}
				else {
					/*
						BUSCAR SI HAY UN CONTROLADOR Y ACCION PARA ESTE URL
					*/
					if (
						file_exists($_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/controllers/'.$url_parts[0]."_controller.php")
						|| file_exists($_SERVER["DOCUMENT_ROOT"].'/frontbase/default_controllers/'.$url_parts[0]."_controller.php")
					) {
						
						$this->controller = $url_parts[0];
						if (isset($url_parts[1]))
							$this->action = $url_parts[1];
						else
							$this->action = "index";
							
	
						for ($i = 2; $i <= 6; $i++) { 
							if (isset($url_parts[$i]) && strlen($url_parts[$i])>0 )
								$this->args[] = $url_parts[$i];
						}
					}
					else {
						/*
							ARBITRARY ROUTES
							Si no hay controlador y action, ver en las rutas
						*/
						$routes = get_routes_for($this->lang);

						$url_mapper = new RoutesMapper($neutral_uri, $routes);
						if ($url_mapper->found) {
							$this->action = $url_mapper->action;
							$this->controller = $url_mapper->controller;
							if (strlen($url_mapper->args)>0)
								$this->args[] = $url_mapper->args;
						}
						else {
							/*
								MODELS URLS routes_for_models
								Si no hay controlador y action ni tapoco ruta, ver en las rutas de modelos
								TODO: recursividad para /pais/34/provincia/2/comuna/4
								TODO: verificacion de integridad o si no, 404
							*/
							$routes_for_model = get_model_route_for($this->lang);
							if (isset($routes_for_model[$url_parts[0]]) && is_numeric($url_parts[1])) {
									$this->model = $routes_for_model[$url_parts[0]]["model"];
									$this->item_id = $url_parts[1];
									$this->pass_as = $routes_for_model[$url_parts[0]]["pass_as"];
									
									$url_parts = array_slice($url_parts, 2);
									$url_mapper = new RoutesMapper($neutral_uri, $routes);
									$neutral_uri = implode("/", $url_parts);
									
									$this->controller = $url_parts[0];
									if (isset($url_parts[1]))
										$this->action = $url_parts[1];
									else
										$this->action = "index";
									if (isset($url_parts[2]))
										$this->args[] = $url_parts[2];
									if (isset($url_parts[3]))
										$this->args[] = $url_parts[3];
									if (isset($url_parts[4]))
										$this->args[] = $url_parts[4];
							}
						}
					}
				}
			} else {
				/*
					ES LA PAGINA PRINCIPAL DEL IDIOMA POR DEFECTO get_default_lang() ussually english or spanish
				*/
				$this->controller = $default_controller;
				$this->action = "index";
			}
		}
		function getJumURL($switch_to_lang) {
				return url_for($this->controller,$this->action, $this->args, $switch_to_lang);
		}
	}