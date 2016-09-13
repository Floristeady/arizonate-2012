<?


class _pdo_test_controller extends PortalController{
	function __construct() {
		parent::__construct();
		$this->no_footer_debug = true;
	}

	function dinamic_langs() {
		$ct = new ContentTool();
		$content = $ct->find(11);
		$content->URL = array("es" => "Hola", "en" => "Hello");
		$content->save();
	}


}

