<?


class _login_controller extends PortalController{
	function __construct() {
		parent::__construct();
	}

	function index() {
 		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 			if (PassportControl::authenticate_and_allow($_POST["username"],$_POST["password"])) {
 				header("location: ".url_for("main", "index"));
 				die();
 			}
 			else {
 				FlashMessage::set("Usuario o contraseña no válidos");
 			}
 		}
		if (exists_configuration_param("scaffold_login_layout")) {
			$this->layout_file = get_configuration_param("scaffold_login_layout");
		}
		else
			$this->layout_file = "main";
		$this->page_file = "login";
	}
	function logout() {
			PassportControl::logout();
			header("location: ".url_for("login", "index"));
	}

}


?>