<?


class _support_controller extends PortalController{
	function __construct() {
		parent::__construct();
		$this->no_footer_debug = true;
	}

	function clear_cache() {
		
	}
	function test_simple_email($to = null) {
		if (is_null($to)) {
			$to= get_configuration_param("web_mailbox");
		}
		
		$subject="Test";
		$header="from: name <webmaster@rugendas.cl>";
		$message="Hello \r\n";
		$message.="This is test\r\n";
		$message.="Test again ";
		$sentmail = mail($to,$subject,$message,$header);
	
		if($sentmail){
			echo "Email Has Been Sent to ".$to;
		}
		else {
			echo "Cannot Send Email to ".$to;
		}
		exit();
	}

}

