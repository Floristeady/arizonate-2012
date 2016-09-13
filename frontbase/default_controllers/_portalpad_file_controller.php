<?


class _portalpad_file_controller extends PortalController{
	function __construct() {
		parent::__construct();
		$this->no_footer_debug = true;
		$this->layout_file = null;
	}
	/*solo de portalpad*/
	function download($file) {
			if (is_object($file)) {
				if (file_exists($_SERVER["DOCUMENT_ROOT"].$file->getPath())) {
					header('Content-type: application/'.$file->getExtension());
					header('Content-Disposition: attachment; filename="'.$file->original_filename.'"');

					// fix para MsOffice+IE+SSL
					header('Cache-Control: ');
					header('Pragma: ');

					readfile($_SERVER["DOCUMENT_ROOT"].$file->getPath());	
				}
				else {
					$this->error_404();
				}
				$this->no_footer_debug = true;
				$this->layout_file = null;
			}
	}
	/*general*/
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
	/*solo de portalpad*/
	function get_from_filename($file_name) {
		/*
		Controlador para:
		RewriteRule ^assets/files/(.*)$ _file/get_from_filename/$1 [L,QSA]
		*/
		
		// checkear si existe??
		// fix para MsOffice+IE+SSL (cache)?
		
		if (FileTool::check_access_by_file_name($file_name)) {
			header('Content-type: application/'.FileTool::get_extension($file_name));
			readfile($_SERVER["DOCUMENT_ROOT"]."/site/portalpad_upload/".$file_name);	

		}	
		else {
			$this->error_404();	
		}
	}

	

}

