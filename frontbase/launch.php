<?
	//echo $_REQUEST["URI"];
	$frontbase_flag = true;

	if (function_exists("memory_get_usage")) {
		$mem_initial = memory_get_usage();
	}
	$benchmark_start = microtime(true);
	
	include($_SERVER["DOCUMENT_ROOT"].'/conf/config.php');

	include('core.php');

	
	/* 
		HTTPS-ONLY handler
	*/
	if (get_configuration_param("https_only") && !$_SERVER["HTTPS"]) {
		// TODO: mover a launch?
		$url = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		header("location: https://".$url);
		die();
	}

	include('lang.php');

	if (get_env() != "production") {
		error_reporting(6135);
		ini_set("display_errors", 1);	
	}
	else {
		error_reporting(0);
	}
	if (get_configuration_param("set_memory_limit")>0) {
		ini_set("memory_limit", get_configuration_param("set_memory_limit")."M");	
	}
	if (get_configuration_param("auto_start_session")) {
		session_start();
	}


		
	$default_controller = "main";

	/* 
		CONNECT TO DATABASE
	*/

	db_connect();
	
	$requested_uri = $_REQUEST["URI"];
	/*
		PHPINFO HANDLER
	*/

	if ($env != "production" && $requested_uri == "phpinfo") {
		phpinfo();
		die();
	}
	/* 
		TEST HANDLE
	*/
	if ($requested_uri == "" && isset($_GET["test"])) {
		include("frontbase/test/index.php");
		die();
	}

	/* 
		URL evaluation
	*/

	Logger::benchmark("will resolve URL",(microtime(true) - $benchmark_start));


	$ur	= new URLResolver();
	$ur->resolve($requested_uri);
	$controller = $ur->controller;
	$action = $ur->action;
	$args = $ur->args;
	$lang = $ur->lang;
	
	/*
		EXPERIMENTAL EN AC
	*/
	if (file_exists($_SERVER["DOCUMENT_ROOT"].'/conf/'.get_current_site_space()."/config.php")) {
		include($_SERVER["DOCUMENT_ROOT"].'/conf/'.get_current_site_space()."/config.php");
	}

	if (file_exists($_SERVER["DOCUMENT_ROOT"]."/sites/".get_current_app()."/config.php")) {
		/* 
		EXPERIMENTAL. No estoy seguro si debe haber un config en el sites 
		Problemas para sobreescribir variables con $conf_all ($conf[env] se impondrá) por ejemplo:
		Sol: crear funcion Settings::set?
		usar conf/get_current_app()/confing.php?
		*/
		include($_SERVER["DOCUMENT_ROOT"]."/sites/".get_current_app()."/config.php");	
	} 

	/*
		LOAD MODELS, COMPONENTS AND LIBRARIES (RIGHT AFTER RESOLVE)
	*/
	include("components_load.php");

	/*
		HANDLE GIVEN MODELS
	*/

	if (isset($ur->model) && isset($ur->item_id)) {
		$url_model_tool = $ur->model."Tool";
		$mt = new $url_model_tool();
		$url_model_item = $mt->find($ur->item_id);
		unset($mt);
	}

	/* 
		Incorporate languages
	*/

  if (count($langs)>0) {
  	if (file_exists($_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/langs/lang_'.get_current_lang().'.php')) {
    	include($_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/langs/lang_'.get_current_lang().'.php');
  	}
	}

	if (!isset($controller)) {
		/* 
			NOT FOUND HANDLER
		*/
		$controller = $default_controller;
		$action = "error_404";
		$is_found = false;
	}
	else {
		$is_found = true;
		if (!(strlen($action) > 0)) {
			$action = "index";
		}
	}
	function is_found() {
		global $is_found;
		return $is_found;
	}
	Logger::benchmark("will run action",(microtime(true) - $benchmark_start));

	/* 
		CONTROLLER HANDLER (ALL URL MUST LEAD TO A CONTROLLER EVEN IF 404)
	*/

	// TODO: arreglar duplicacion de run_action, 
	// IMPORTANTE: headers must be sent before run_action!

	if (substr($action,0,5) == "ajax_") {
		/*
			SOPORTE automatico para AJAX
		*/
		//TODO: Soporte a prueba de errores para AXAJ Y JSON
		//TODO: implementar header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		//TODO: implementar header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		
		if (get_charset() != null)
			header('Content-type: text/plain; charset='.get_charset());
		else
			header('Content-type: text/plain; charset=iso-8859-1');

		$instance = run_action($controller, $action, $args);
		if (isset($instance->page_file))
			$page_file = $instance->page_file;

		$layout_file = null;
		$instance->no_footer_debug= true;	
	}
	else {
		/*
			Si no hay un page_file especificado, tomar el nombre de la acción
		*/
		$instance = run_action($controller, $action, $args);
		if (isset($instance->page_file))
			$page_file = $instance->page_file;
			
		if (!isset($instance->page_file))
			$page_file = $action;	
			
		$layout_file = $instance->layout_file;
		$message_file = $instance->message_file;
		$error_file = $instance->error_file;
		if (isset($instance->sublayout_file))
			$sublayout_file = $instance->sublayout_file;
	}
	
	if (!$instance->PortalController_contructor_executed && !$instance->no_footer_debug) {
		echo "missing parent::__construct() in controller";
		die();
	}


	/*
		TEMPLATES OUTPUT
	*/
	Logger::benchmark("will yield",(microtime(true) - $benchmark_start));
	the_yield();

	/*
		BENCHMARKING
	*/

	if ($env != "production") {
		$benchmark_stop = microtime(true);
		$benchmark_total = $benchmark_stop - $benchmark_start;
		if(!$instance->no_footer_debug) {
			if ($env == "development") {

				include('portalpad_debug.php');
			}
			
			echo "<div style='padding: 4px; text-align: center; clear: both;font-family: arial; color: #b1b1b1; font-size: 11px;'>Processing time: $benchmark_total seconds</div>";
		}


	}
	unset($instance);
	unset($page);
	unset($header);