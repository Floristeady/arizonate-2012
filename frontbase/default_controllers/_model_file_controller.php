<?


class _portalpad_file_controller extends PortalController{
	function __construct() {
		parent::__construct();
		$this->no_footer_debug = true;
		$this->layout_file = null;
	}

	/*general solo para enviro*/
	function download_model_attachment($model, $id) {
		/*
		Controlador para:
		RewriteRule ^assets/files/models/(.*)/(.*)$ _file/download_model_attachment/$1/$2 [L,QSA]
		*/
		$tool_name = $model."Tool";
		$tool = new $tool_name();

		if ($object = $tool->find($id)) {
			$this->download($object->file);
		}	
		else {
			$this->error_404();
		}

	}

	

}

