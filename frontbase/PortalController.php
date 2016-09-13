<?

	class PortalController {
		function __construct($avoid_restrictions = false) {
			$this->headers = array();
			$this->models = array();
			$this->data = array();
			$this->data["breadcumb"] = array();

			$this->page = new Page();
			$this->page->head->addCss("/frontbase/portalpad_debug.css");
			
			// TODO: Mover a destructor para que sea manipulable desde el controlador
			$this->setData("page",$this->page);
			

			foreach (get_current_models() as $model) {
				// TODO: implementar pass_as from routes_model
				// autoload a $this->current_modelX here?
				if ($model) {
					$name = "current_".strtolower(get_class($model));
					$this->models[$name] = $model;
					Logger::info("URL model <$name> loaded into Controller", $this->models[$name]);
				}
				else {
					// TODO: throw: 404
					echo "not found";
					die();	
				}
			}

			// RESTRICCION DE ACCESO
			// TODO: reenviar a la URL requerida despues del login
			// TODO: restriccion de acceso por controlador o URL segment
			
			if (strlen(get_configuration_param("login_controller"))>0)
				$login_controller_name = get_configuration_param("login_controller");
			else
				$login_controller_name = "_login";
				
			
			if (get_configuration_param("restricted")
				&& get_class($this) != $login_controller_name."_controller"
				&& !$avoid_restrictions
				) {
				// TODO: mover a una function aparte a ser llamada desde launch? en el constructor en inseguro
				if (!PassportControl::is_allowed()) {
					header("location: ".url_for($login_controller_name, "index"));
					die();
				}
			}
			$this->PortalController_contructor_executed = true;
		}
		function error_404() {
			header('HTTP/1.0 404 Not Found');
			$this->error_file = "404";
			$this->layout_file = "main";
			$this->sublayout_file = null;
			$error_page_path = $_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/templates/errors/'.$this->error_file.".php";
			if (!file_exists($error_page_path)) {
				echo "404 not found";
				die();
			}

		}
		function setData($arg1, $data = null) {
			if (!is_array($arg1)) {
				if (!in_array($arg1, array("file"))) {
					$this->data[$arg1] = $data;
				}
				else {
					die($arg1." is a reserved variable");
				}
			}
			else {
				foreach ($arg1 as $key => $value) {
					$this->data[$key] = $value;
				}
			}
		}
		function getData($key) {
			return $this->data[$key];
		}
		function addToNavigation($arg1, $arg2 = null) {
			if (is_array($this->data["navigation_elements"]))
				$last = end($this->data["navigation_elements"]);
			if (is_object($arg1) && (get_class($arg1) == "Content" || get_class($arg1) == "Section")) {
				if ($last["title"] != $arg1->getPublicName()) 
					$this->data["navigation_elements"][] = array("title" => $arg1->getPublicName(), "url" => $arg1->getItemLink());
			}
			elseif (strlen($arg1) > 0 && strlen($arg2) > 0) {
				if ($last["title"] != $arg1) 
					$this->data["navigation_elements"][] = array("title" => $arg1, "url" => $arg2);
			}
			
		}
		function disableCache() {
			header("Cache-Control: no-cache, must-revalidate");	
			$this->page->head->addMetaTag("PRAGMA", "NO-CACHE");
			$this->page->head->addMetaTag("EXPIRES", "-1");
		}
	  function __call($method, $arguments) {
			if (substr($method,strlen($method)-11,strlen($method)) == "_as_partial") {
				$action = substr($method,0,strlen($method)-11);
				if (get_charset() != null)
					header('Content-type: text/plain; charset='.get_charset());
				else
					header('Content-type: text/plain; charset=iso-8859-1');				
					
				call_user_func_array(array($this, $action), $arguments);
				$this->page_file = $this->partial_file;
				$this->layout_file = null;
				$this->sublayout_file = null;
				$this->no_footer_debug = true;
			} elseif ($method != "after_action") {
		  	if (get_env() != "production") {
					$this->page_file = $method;
				} else {
					$this->error_404();
				}
			}

			
	  }
	}