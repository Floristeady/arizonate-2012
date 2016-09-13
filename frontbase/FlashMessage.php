<?
	class FlashMessage {
		function set($str) {
			//echo "set()";
			Session::set("message", $str);
		}
		function get() {
			//echo "get()";
			if (strlen(Session::get("message"))>0) {
				$message = (string)Session::get("message");
				Session::set("message","");
				
				return $message;
			} else {
				return false;
			}
		}
	}