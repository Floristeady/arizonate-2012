<?


class _sql_controller extends PortalController{
	function __construct() {
		parent::__construct();
		$this->no_footer_debug = true;
	}

	function dynamic_attributes($model) {
		header("Content-type: text/plain");
		$this->page_file = "dynamic_attributes";
		$this->setData("table", strtolower($model)."s");
		$this->setData("model", $model);
		$this->setData("fk", strtolower($model)."_id");
	}
	function langs($model) {
		header("Content-type: text/plain");
		$this->page_file = "langs";
		$this->setData("table", strtolower($model)."s");
		$this->setData("model", $model);
		$this->setData("fk",  strtolower($model)."_id");

	}
}

