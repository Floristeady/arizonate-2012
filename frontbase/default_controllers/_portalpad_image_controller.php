<?


class _portalpad_image_controller extends PortalController{
	function __construct() {
		parent::__construct();
	}
	/*solo de portalpad*/
	function get_resized($file_name, $width,  $height = null) {
		if (get_configuration_param("check_image_access")) {
			if (!FileTool::check_access_by_file_name($file_name)) {
			 $this->error_404();	
			 return false;
			}
		}
		

		$this->no_footer_debug = true;
		$this->layout_file = null;
		$this->sublayout_file = null;

		if (strlen($file_name) > 0) {

			$img = new ImageProcessor("/site/portalpad_upload/".$file_name);
			if ($height > 0) {
				$img->printResized($width, $height);
			}
			else {
				$img->printResized($width);
			}
		}

	}
	function get($file_name) {
		
		header('Content-type: image/jpg');

		readfile($_SERVER["DOCUMENT_ROOT"]."/site/portalpad_upload/".$file_name);
		exit();
	}

}

