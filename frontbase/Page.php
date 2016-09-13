<?

	class Page {
		function Page() {
			$this->head = new HeadHelper();
		}
		function badbrowser_alert($style="border: 2px red solid; padding: 6px; background-color: white;") {
				$using_ie6 = (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.') !== FALSE);
				if ($using_ie6) {
					return "
					<div style='$style'>You are using IE 6, an old and unsecure browser. Please upgrade!</div>";
				}
	
		}
		function setTitle($title) {
			$this->head->title = $title;
		}
		function addPlugin($name, $settings = array()) {
			$this->plugins[] = $name;
			$plugin_relative_path = "/js/lib/".$name."/";
			$plugin_physical_path = $_SERVER["DOCUMENT_ROOT"].$plugin_relative_path;
			if (!file_exists($plugin_physical_path)) {
				$plugin_relative_path = url_for_static($plugin_relative_path);
				$plugin_physical_path = $_SERVER["DOCUMENT_ROOT"].$plugin_relative_path;
				if (!file_exists($plugin_physical_path)) {
					if (get_env() != "production") {
						echo "plugin path at ".$plugin_relative_path." not found";
						die();
					}
				}
			}
			if (file_exists($plugin_physical_path."deploy.php")) {
				$external_required_libraries = array();
				$required_libraries = array();
				include($plugin_physical_path."/deploy.php");
				
				// Librerias JS internas
				if (is_array($required_libraries)) {
					foreach($required_libraries as $library) {
						$this->head->addScript($plugin_relative_path.$library);
					}
				}
				if (is_array($required_stylesheets)) {
					foreach($required_stylesheets as $stylesheet) {
						$this->head->addcss($plugin_relative_path.$stylesheet);
					}
				}
				$class_name = $name."_plugin";
				if (class_exists($class_name)) {
					$object_instance = new $class_name($this);
					$object_instance->setPath($plugin_relative_path);
					$object_instance->settings = array_merge($object_instance->settings,$settings);
					$object_instance->init();
					if (method_exists($object_instance, "header_init_script")) {
						ob_start();
				    call_user_func(array($object_instance, "header_init_script"));
				    $this->head->addEmbedScript(ob_get_contents());
				    ob_end_clean();
					}
					if (method_exists($object_instance, "getDocumentReady")) {
						$this->addDocumentEvent("ready", call_user_func(array($object_instance, "getDocumentReady")));
					}
				}
			}
			else {
				if (get_env() != "production") {
					echo "deploy file does not exists for $name plugin";
					die();
				}
			}

		}
		function setCharset($charset = "iso-8859-1") {
			$this->head->setCharset($charset);

		}
		function addDocumentEvent($event, $code) {
			$this->head->addDocumentEvent($event, $code);
		}
	}