<?


class _model_image_controller extends PortalController{
	function __construct() {
		parent::__construct();
	}

	function get_resized($model,$id, $field, $width, $height = null) {
		$this->no_footer_debug = true;
		$this->layout_file = null;
		$this->sublayout_file = null;
		
		$toolname = ucwords($model)."Tool";
		$tool = new $toolname;
		if (!($instance = $tool->find($id))) {
			Logger::error("_model_image_controller: could not find model <$model> with id <$id>");	
			die();
		}
		
		$image = $instance->$field;
		if (empty($image)) {
			Logger::error("_model_image_controller: no image found in field <$model>:<$field> for id <$id>");	
			die();			
		}

		$img = new ImageProcessor($image->getPath());
		if (!is_null($height) && $height > 0) {
			$img->printResized($width, $height);
		}
		else {
			$img->printResized($width);
		}


	}

}

