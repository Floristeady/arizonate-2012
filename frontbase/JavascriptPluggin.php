<?
	class JavascriptPluggin {
		function __construct(&$page) {
			$this->page = &$page;	
			$this->settings = array();
		}
		function setPath($path) {
			$this->path = $path;
		}
		function getPath(){
			return $this->path;
		}
		function setSetting($name, $value) {
			$this->settings[$name] = $value;
		}
	
	}
