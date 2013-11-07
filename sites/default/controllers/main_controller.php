<?

class main_controller extends PortalController{
	function main_controller() {
		parent::__construct();
		$this->layout_file = "main";
	}
	function index() {}
	function teverde_miel() {}
	function teverde_granada() {}
	function teblanco_arandano() {}
	
	function tediet_miel() {}
	function tediet_arandano() {}
	function tediet_fram() {}
	function tediet_limon() {}
	
	function tehelado_fram() {}
	function tehelado_limon() {}
	function tehelado_mango() {}
	
	function nectar_mango() {}
	function nectar_naranja() {}
	function nectar_uva() {}
	function nectar_sandia() {}
	function nectar_limonada() {}
	
	function energetica() {}
	
	function salud() {}
	
	function comprar() {
	
			$this->setData("errors",array());

	}
	function submit_compra() {
			$errors = array();
			if (is_empty($_POST["nombre"])) {
				$errors["nombre"] = "Nombre es requerido";	
			}
			if (is_empty($_POST["telefono"])) {
				$errors["telefono"] = "telefono es requerido";	
			}
			if (is_empty($_POST["direccion"])) {
				$errors["direccion"] = "Direccion es requerido";	
			}
			if (is_empty($_POST["comuna"])) {
				$errors["comuna"] = "Comuna es requerido";	
			}
			if (is_empty($_POST["ciudad"])) {
				$errors["ciudad"] = "Ciudad es requerido";	
			}
			if (ValidationTool::is_email($_POST["ciudad"])) {
				$errors["email"] = "e-mail es requerido";	
			}
			$found = false;
			foreach ($_POST["productos"] as $q) {
				if ($q > 0) {
					$found = true;
				}
			}
			if (count($_POST["mixes"]) > 0) {
				$found = true;
			}
			if (!$found) {
				$errors["productos"] = "Debe seleccionar como mínimo algún producto o algún mix";	
			}
			$this->setData("errors",$errors);

			
			if (count($errors) == 0) {			
				$fh = new FormHandler("orden_de_compra", $_POST);
				$fh->replyto_address = $_POST["email"];
				$fh->setSubject("Orden de compra Bebidas AriZona");
				if ($fh->sendByEmail(get_configuration_param("web_mailbox_venta"))) {
					$persona = new Persona();
					$persona->nombre = $_POST["nombre"];
					$persona->apellido = $_POST["apellido"];
					$persona->email = $_POST["email"];
					$persona->save();
					$message = "Gracias, su orden de compra ha sido recibida";
				} else {
					$message = "Ha habido un error al recibir su orden de compra";
				}
				$this->setData("message_body",$message);
				$this->message_file = "default";
			}
			else {
				$this->page_file = "comprar";
			}

	}
	function contacto() {
	
	}
	function submit_contacto() {
		$rules["nombre"] = "required";
		$rules["email"] = "email";
		$rules["mensaje"] = "required";
		
		$vt = new ValidationTool();
		
		if ($vt->run_on_post($rules, "contacto")) {

			$fh = new FormHandler("contacto", $_POST["contacto"]);
			$fh->replyto_address = $_POST["contacto"]["email"];
			$fh->setSubject("Contacto Bebidas AriZona");
			if ($fh->sendByEmail(get_configuration_param("web_mailbox"))) {
				$persona = new Persona();
				$persona->nombre = $_POST["contacto"]["nombre"];
				$persona->apellido = $_POST["contacto"]["apellido"];
				$persona->email = $_POST["contacto"]["email"];
				$persona->save();
				$message = "Gracias, tu mensaje ha sido enviado. Pronto nos contactaremos contigo.";
			} else {
				$message = "Ha habido un error al enviar el mensaje";
			}
			$this->setData("message_body",$message);
			$this->message_file = "default";
		}
		else {
			$this->contacto();
			$this->setData("vt",$vt);
			$this->page_file = "contacto";
		}
	}
	
	

	
}
?>