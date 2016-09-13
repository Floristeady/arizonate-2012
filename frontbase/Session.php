<?
	class Session {
		public function __construct() {
			self::commence();
		}
		public function commence(){
			if (!isset($_SESSION['ready']) && !get_configuration_param("auto_start_session")) {
				session_start();
				$_SESSION['ready'] = TRUE;
			}
		}
		public function set($fld,$val){
			self::commence();
			$_SESSION[$fld] = $val;
		}
		public function un_set($fld) {
			self::commence();
			unset($_SESSION[$fld]);
		}
		public function destroy(){
			self::commence();
			unset($_SESSION);
			session_destroy();
		}
		public function get($fld){
			self::commence();
			return $_SESSION[$fld];
		}
		public function is_set($fld) {
			self::commence();
			return isset($_SESSION[$fld]);
		}
	} 
