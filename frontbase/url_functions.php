<?
	function get_routes_for($lang) {
		/*
			TODO: mover INCLUDE() al core para que no se repita los includes varias veces
		*/
		if ($lang != get_default_lang()) {
			$routes_path = $_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/routes_'.$lang.'.php';
			if (file_exists($routes_path)) {
				if (include($routes_path)) {
					return $routes;
				}
				else {
					return false;	
				}
			}
			else {
				return false;	
			}
		}
		else {
			if (file_exists($_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/routes.php')) { 
				if (include($_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/routes.php')) {
					return $routes;
				}
				else {
					return false;
				}
			}
			else {
				return false;
			}
		}
	}
	function get_model_route_for($lang) {
		/*
			TODO: mover INCLUDE() al core para que no se repita los includes varias veces
		*/
		if ($lang != get_default_lang()) {
			if (file_exists($_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/routes_model_'.get_current_lang().'.php') &&	include($_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/routes_model_'.get_current_lang().'.php')) {
				return $routes_for_model;
			}
			else {
				return false;	
			}
		}
		else {
			if (file_exists($_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/routes_model.php')	&& include($_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/routes_model.php')) {
				return $routes_for_model;
			}
			else {
				return false;
			}
		}
	}
	
	function find_route_for($controller, $action, $args, $force_lang = null) {
		/*
			array("user","main","user", array(arg1, arg2)),
			$args puede ser array o integer
			$route[3] puede  ser array o integer
		*/
		if (strlen($force_lang) == 2) {
			$routes = get_routes_for($force_lang);
			
		}
		else {
			$routes = get_routes_for(get_current_lang());
		}
		if ($routes) {
			// Normaliza el argumentos de comparacion y provenientes de routes para ser comparados
			if (!is_array($args))
				$args = array($args);

			foreach($routes as $route) {
				$route_arg = $route[3];
				// Normaliza los argumentos de comparacion y provenientes de routes para ser comparados
				if (!is_array($route_arg))
					$route_arg = array($route_arg);
				if ($route[1] == $controller && $route[2] == $action && (is_null($args) || $route_arg == $args)) {
					// GOTCHA if($route[0]) evalua como falso si $uri es ''
					return $route[0];
				}
			}
		}
		return false;
	}

	function url_for($controller, $action = "index", $args = null, $force_lang = null) {
		global $ur;
		// GOTCHA if($uri) evalua como falso si $uri es ''
		if (!(false === ($uri = find_route_for($controller, $action, $args, $force_lang)))) {
			// ruta encontrada
			$uri = get_url_base($force_lang)."/".$uri;
		}
		else {
			if (is_array($args))
				$uri = get_url_base($force_lang)."/".$controller."/".$action."/".implode("/", $args);
			elseif (isset($args))
				$uri = get_url_base($force_lang)."/".$controller."/".$action."/".$args;
			else
				$uri = get_url_base($force_lang)."/".$controller."/".$action."/";
		}
		if (not_empty(get_configuration_param("url_prefix"))) {
			$url_prefix = get_configuration_param("url_prefix");
		}
		if (get_configuration_param("friendly_urls")) {
			if (isset($ur->current_site)) {
				return "/".$url_prefix.$ur->current_site.$uri;
			}
			return $url_prefix.$uri;
		}
		else {
			$index_url = (strpos($_SERVER['SERVER_SOFTWARE'], 'Apache') === FALSE) ? 'index.php' : '';
			return $index_url."/?URI=".$url_prefix.substr($uri,1);
		}
		
	}
	function url_for_action($action, $args = null) {
		global $controller;
		return url_for($controller,$action, $args);
	}
	function url_to_absolute($str) {
		return "http://".$_SERVER["SERVER_NAME"].$str;
	}
	function url_for_self($extra_args = array()) {
		global $ur;
		return url_for($ur->controller, $ur->action, $ur->args);
	}
	function url_for_static($path) {
		return "/sites/".get_current_site_space()."/static/".$path;
	}