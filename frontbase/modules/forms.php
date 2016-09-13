<?


	function parse_email_template($source, $filename, $parameters) {
		// $source es "f" para file
	    if (is_file($filename)) {
	    		extract($parameters);
	        ob_start();
	        include $filename;
	        $contents = ob_get_contents();
	        ob_end_clean();
	        return $contents;
	    }
	    echo "template not found ".$filename;
	    return false;
	}

	function unique_filename($xtn = ".tmp") {
	  return mktime().rand(10000,99999).".".$xtn;
  } 

	function findexts ($filename)	{
		$filename = strtolower($filename) ;
		$exts = split("[/\\.]", $filename) ;
		$n = count($exts)-1;
		$exts = $exts[$n];
		return $exts;
	} 

	function uploadFileToStore($name_space, $input_name = 'userfile') {
		$file_name = unique_filename(findexts(basename($_FILES[$input_name]['name'])));
		$target_path = $_SERVER["DOCUMENT_ROOT"]."/site/store/".$file_name;
		
		if(move_uploaded_file($_FILES[$input_name]['tmp_name'], $target_path)) {
			return $file_name;
		}
		else {
			return false;
			}
	}
		
	class FormHandler {
		function FormHandler($namespace = "", $parameters = null) {
			$this->namespace = $namespace;
			if (isset($parameters))
				$this->parameters = $parameters;
			else
				$this->parameters = array();
		}
		function setParameters($parameters) {
			foreach ($parameters as $key => $parameter){
				$this->parameters[] = $parameter;
			}
		}
		function sendByEmail($to, $attachment_path = null) {
			// TODO: transformar $this->parameters en resultados legibles (SELECTS?)
			// TODO: apeptar varias direcciones de email separadas por comas, espacios o pipes, o inluso un array.
			$mh = new MailHelper();

			$addresses = explode(",",$to);
			foreach ($addresses as $address) {
				$mh->addRecipient(trim($address));
			}

			$mh->from_name = get_configuration_param("mail_from_name");
			if (isset($this->subject))
				$mh->subject = $this->subject;
			else
				$mh->subject = get_configuration_param("mail_subject");
			
			if (isset($this->replyto_address))
				$mh->replyto_address = $this->replyto_address;

			$mh->body = parse_email_template("f", $_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/templates/emails/'.$this->namespace.".php", $this->parameters);

			if (file_exists($_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/templates/emails/plain/'.$this->namespace.".php")) {
				
				$mh->plain_body = parse_email_template("f", $_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/templates/emails/plain/'.$this->namespace.".php", $this->parameters);
			}
			else {
				Logger::warn("no plain version found for '".$this->namespace."'");
			}
			
			if (isset($attachment_path)) {
				$mh->attachment_path = $attachment_path;
			}
			
			// TODO: poner en una funcion o componente? 
			
			if (get_configuration_param("forms_input_backup")) {
				$backup_path = $_SERVER["DOCUMENT_ROOT"].'/site/form_backup/';
				if (file_exists($backup_path)) {
					$backup_file_name = $this->namespace."_".date("Y-m-d")."_".date("His")."_".$_SERVER["REMOTE_ADDR"].".html";
					$backup_file = @fopen($backup_path.$backup_file_name, 'w');
					$backup_data = $mh->subject."\n".$mh->body;
					@fwrite($backup_file, $backup_data); 
				}
			}
			
			return $mh->send();
		}
		function send($to, $attachment_path = null) {
			$this->sendByEmail($to, $attachment_path);
		}
		function setSubject($subject) {
			//TODO: procesar variables
			$this->subject = $subject;
		}		
		function saveToDB($table_name) {
			
		
		}
	}
	class Notificacion {}
	class UserNotification extends Notificacion {
		function UserNotification($notificacion_name, $fields = array()){
			$this->notificacion_name = $notificacion_name;
			$this->fields = $fields;
		}
		function send($to) {
			// TODO: aceptar class User?
			$addresses = explode(",",$to);
			
			$mh = new MailHelper();

			foreach ($addresses as $address) {
				$mh->addRecipient(trim($address));
			}
			$mh->from_name = get_configuration_param("mail_from_name");
			
			if (isset($this->subject))
				$mh->subject = $this->subject;
			else
				$mh->subject = "Notification";
			
			if (isset($this->replyto_address))
				$mh->replyto_address = $this->replyto_address;
				
			$mh->body = parse_email_template("f", $_SERVER["DOCUMENT_ROOT"].'/sites/'.get_current_site_space().'/templates/emails/'.$this->notificacion_name.".php", $this->fields);
			return $mh->send();

				
		}
		
	}

	/* DEPRECAted by ValidationTool::display_errors */
	
	function display_errors($vt) {
		if (isset($vt)) {
			echo "<div class='errors'>";
			echo "<ul>";
			foreach ($vt->errors as $error) {
				echo "<li>".$error."</li>";
			}	
			echo "</ul>";
			echo "</div>";
		}
	}
	


