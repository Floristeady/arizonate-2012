<?
	@include($_SERVER["DOCUMENT_ROOT"].'/conf/auto_env.php');
	
	if ($dmode == "dbug")
		include('lib/dBug.php');
	elseif ($dmode == "krumo") 
		include('lib/krumo/class.krumo.php');
	else
		include('lib/krumo/class.krumo.php');
	
	# TODO: poner hooks en /sites/sitename
	@include($_SERVER["DOCUMENT_ROOT"].'/conf/hooks.php');
	
	include("Logger.php");
	Logger::benchmark("will start including libraries at core",(microtime(true) - $benchmark_start));
	
	include('error_handling.php');

	include('Translatable.php');
	include('filter_functions.php');
	include('helpers.php');
	include('modules/forms.php');
	include('Page.php');
	include("PortalController.php");
	include('PortalDataObject.php');
	include('PortalDataObjectTool.php');
	include('PortalDataFile.php');
	include("RoutesMapper.php");
	include('Session.php');
	include("url_functions.php");
	include('URLResolver.php');

  define("HIGH_PRIORITY", 100);
  define("NORMAL_PRIORITY", 0);
  define("LOW_PRIORITY", -100);

	function sqlfilter($str) {
		if(get_magic_quotes_gpc() == 1) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	function db_connect() {
		$dbh=@mysql_connect (get_db_param("host"), get_db_param("user"), get_db_param("pw")) or 
			error_screen('No se pudo conectar al servidor de base de datos','No se puede conectar con la configuracion especificada en <strong>'.get_env()."</strong>");
		@mysql_select_db (get_db_param("db")) or 
			error_screen('No se pudo conectar con la base de datos',"Se puede conectar con el servidor, pero la base de datos especificada no es la correcta");	
		
		if (get_configuration_param("charset") == "UTF-8") 	{
			mysql_query_door("SET NAMES 'utf8'");
		}
		
		return $dbh;
	}
	function mysql_query_door($sql) {
		// TODO: implementar esto??
		//$debug = true;
		if ($debug) { 
			if (!isset($GLOBALS["deleted"])) {
				//mysql_query("DELETE FROM sql WHERE query = '".$_SERVER["QUERY_STRING"]."'");
				$GLOBALS["deleted"] = true;
			}
			$start = microtime();
		}
		if ($result = mysql_query($sql)) {
			if ($debug) { 
				$stop = microtime();
				$time = $stop - $start;
				mysql_query("INSERT DELAYED INTO sql (query, sql, time) VALUES ('".$_SERVER["QUERY_STRING"]."','".mysql_real_escape_string($sql)."', '$time')");
			}
			return $result;
		}
		else {
			if ($debug) { 
				Logger::error("(Using mysql_query_door) SQL ERROR:".mysql_error(),$sql)	;
			}
		}
	}
	function debug(&$var = null, $collapse = false) {
		global $dmode;
		if ($dmode == "dbug") {
			if (class_exists("dBug")) {
				if (!is_null($var)) {
					new dBug($var, "", $collapse);
				}
				else {
					global $instance;
					new dBug($instance->data, "", true);

				}
			}
		}
		else {
			if (class_exists("krumo")) {
				global $instance;
				if (!is_null($var)) {
					krumo($var);
				}
				else {
					krumo($instance->data);
				}
			}
		}
	}
	function get_args() {
		global $args;
		return $args;
	}
	function run_action($controller, $action, $args = null, $url_models = null) {
		if (!class_exists($controller."_controller")) {
			if (substr($controller, 0, 1) != "_") {
				include($_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/controllers/'.$controller."_controller.php");
			}
			else {
				include($_SERVER["DOCUMENT_ROOT"].'/frontbase/default_controllers/'.$controller."_controller.php");
			}
		}
		$controller_class = $controller."_controller";
		$instance = new $controller_class();
		if (isset($args)){
			call_user_func(array($instance, $action),$args[0], $args[1], $args[2], $args[3], $args[4]);
		}
		else
			call_user_func(array($instance, $action));
		
		if (method_exists($instance, "after_action"))
			call_user_func(array($instance, "after_action"));
		return $instance;
			
	}
	function invoque_hook($hook_name, &$arg1) {
		/* TODO: enviorment dependency on hooks??? */
		if (function_exists($hook_name)) {
			$hook_name($arg1);
		}
	}
	function get_current_action() {
		global $action;
		return $action;
	}
	function get_current_controller() {
		global $controller;
		return $controller;
	}
	function the_yield() {	
		global $instance;
		global $controller;
		global $sublayout_file;
		global $layout_file;
		global $page_file;
		global $error_file;
		global $message_file;
		global $ur;
		global $action;
		
		if (isset($instance))
			if(is_array($instance->data))
				extract($instance->data);

		$templates_path = $_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/templates';

		if (isset($layout_file)) {
			$layout_file_temp = $layout_file;
			$layout_file = null;
			$file = $templates_path.'/layouts/'.$layout_file_temp.".php";
		}
		elseif (isset($sublayout_file)) {
			$sublayout_file_temp = $sublayout_file;
			$sublayout_file = null;
			$file = $templates_path.'/sublayouts/'.$sublayout_file_temp.".php";
		}
		elseif (isset($error_file)) {
			$file = $templates_path.'/errors/'.$error_file.".php";
		}
		elseif (isset($message_file)) {
			$file = $templates_path.'/messages/'.$message_file.".php";
		}
		elseif(isset($page_file)) {
			if (!file_exists($templates_path.'/pages/'.$controller.'/'.$page_file.'.php')) {
				if (!file_exists($templates_path.'/pages/'.$page_file.'.php')) {
					if (!file_exists($_SERVER["DOCUMENT_ROOT"].'/frontbase/default_templates/'.$controller.'/'.$page_file.'.php')) {	
						echo "Missing page template: ".$page_file;
					}
					else {
						$file = $_SERVER["DOCUMENT_ROOT"].'/frontbase/default_templates/'.$controller.'/'.$page_file.'.php';
					}
				}
				else {
					$file = $templates_path.'/pages/'.$page_file.'.php';
					
				}
			}
			else {
				$file = $templates_path.'/pages/'.$controller.'/'.$page_file.'.php';
			}
		}
		else {
			if(!$instance->no_footer_debug) {
				echo "Nothing to be shown";
			}
		}
		if (isset($file)) {
			include($file);
		}
	}
	function get_requested_uri() {
		global $requested_uri;
		return $requested_uri;
	}
	function get_env() {
		global $env;
		return $env;
	}
	function get_configuration_param($key) {
		global $conf;
		global $conf_all;
		global $conf_site_specific;
		
		/* 
		Dar la posibilidad de sobreescribir en este orden:
		- sitespace-specific
		- env specific
		- site-wide
		*/
		
		if (isset($conf_site_specific[get_current_site_space()][get_env()][$key])) {
			return $conf_site_specific[get_current_site_space()][get_env()][$key];
		}
		elseif(isset($conf[get_env()][$key])) {
			return $conf[get_env()][$key];
		}
		else {
			return $conf_all[$key];
		}
	}
	function get_charset() {
		return get_configuration_param("charset");
	}
	function exists_configuration_param($key) {
		global $conf;
		global $conf_all;
		global $conf_site_specific;
		
		if (is_array($conf_site_specific[get_current_site_space()][get_env()]) && array_key_exists($key, $conf_site_specific[get_current_site_space()][get_env()]) ) {
			return true;
		}
		elseif(is_array($conf[get_env()]) && array_key_exists($key, $conf[get_env()]) ) {
			return true;
		}
		elseif(is_array($conf_all) && array_key_exists($key, $conf_all) )  {
			return true;
		}
		return false;	
	}
	function get_db_param($key) {
		global $db;
		return $db[get_env()][$key];
	}
	function get_current_site_space() {
		return get_current_app();
	}
	function get_current_app(){
		global $sitespaces;
		global $ur;

		if (isset($ur->current_site)) {
			return $ur->current_site;
		}
		if (strlen($sitespaces[$_SERVER["HTTP_HOST"]])>0)
			return $sitespaces[$_SERVER["HTTP_HOST"]];
		else
			return "default";
	}
	function get_current_domain() {
			$http_host = $_SERVER["HTTP_HOST"];
			if ("www." == substr($http_host, 0, 4))
				$http_host = substr($http_host,4);
			return $http_host;
	}
	function get_current_models() {
		// TODO: Soporte para varios URL models
		global $url_model_item;
		$models = array();
		if ($url_model_item) {
			$models[] = $url_model_item;
		}
		return $models;	
	}
	function get_current_time() {
		// Implementacion de Time-Machine
		return mktime();
	}
	
	function template_path($path) {
		return $_SERVER["DOCUMENT_ROOT"]."/sites/".get_current_site_space()."/templates".$path;
	}
	function has_sitespaces() {
		global $sitespaces;
		if (is_array($sitespaces) && count($sitespaces)>0) {
			return true;
		}
		else {
			return false;
		}
	
	}


	
	

	Logger::benchmark("will look for models",(microtime(true) - $benchmark_start));
