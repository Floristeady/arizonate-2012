<?


class _bridge_controller extends PortalController{
	function __construct() {
		parent::__construct();
	}

	function fetch() {
		header('Cache-Control: no-cache'); 
		header('Pragma: no-cache');
		
		$url = $_GET["url"];
		
		// TODO: bridge_allowed_hosts con varios hosts
		if (strstr($url,"http://".get_configuration_param("bridge_allowed_host"))){
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curl, CURLOPT_TIMEOUT, 5);
	
	    echo curl_exec($curl);
	    
	    //TODO: handle 404 u cualquiera distinto a 200/304 curl_getinfo con un error_404
	    
			$this->no_footer_debug = true;
			exit();
		}
		else {
			$this->error_404();	
		}
	
	}
}

