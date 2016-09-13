<?

	class MailHelper{
		var $from_name = null;
		var $from_address = null;
		var $recipients = array();
		var $replyto_address = null;
		var $backup_address = null;
		var $subject = null;
		var $body = null;
		//TODO: implementar test_output?
		var $test_output = false;

		function MailHelper($avoid_presetting = false) {
			if (!$avoid_presetting) {
				$this->from_name = get_configuration_param("mail_from_name");
				$this->from_address = get_configuration_param("mail_from_address");
				$this->mail_smtp_auth = get_configuration_param("mail_smtp_auth");
				$this->mail_smtp_hostprefix = get_configuration_param("mail_smtp_hostprefix");
				$this->mail_smtp_hostname = get_configuration_param("mail_smtp_hostname");
				$this->mail_smtp_port = get_configuration_param("mail_smtp_port");
				$this->mail_smtp_username = get_configuration_param("mail_smtp_username"); 
				$this->mail_smtp_password = get_configuration_param("mail_smtp_password");
			}
		}
		public function setFrom($address, $name = null){
			$this->from_name = $name;
			$this->from_address = $address;
		}
		public function setSubject($subject){
			$this->subject = $subject;
		}
		public function setBody($body){
			$this->body = $body;
		}
		public function parseBody($template, $fields = array()) {
			/*
			GOTCHA: cambiados el orden de argumentos
			*/
			$template_path = $_SERVER["DOCUMENT_ROOT"]."/sites/".get_current_site_space()."/templates/emails/".$template.".php";
			if (file_exists($template_path)) {
				$this->setBody(parse_email_template("f", $template_path, $fields));
			}
			else {
				Logger::warn("MailHelper::parseBody(): template does not exists in ".$template_path);
				$this->setBody(var_export($fields, true));
			}
		}
		public function parse($parameters = array(), $template, $type = "f") {
			//TODO: soporte para templates desde la BDD
			
			$filename = $_SERVER["DOCUMENT_ROOT"]."/sites/".get_current_site_space()."/templates/emails/".$template.".php";
			
	    if (is_file($filename)) {
	    		extract($parameters);
	        ob_start();
	        include $filename;
	        $contents = ob_get_contents();
	        ob_end_clean();
	        $this->setBody($contents);
	        return true;
	    }
	    else {
	    	Logger::error("Mailhelper::parseBody() Template <".$filename."> not found");
	    	return false;
	    }

		}
		public function has_recipients() {
			if (count($this->recipients["TO"])>0) {
				return true;
			}
			else {
				return false;	
			}
		}
		public function addRecipient($address, $name = "", $type = "TO") {
			// TODO: implementar name
			if (ValidationTool::is_email($address)) {
				$this->recipients[$type][] = trim($address);
			}
			else {
				Logger::warn("MailHelper: addRecipient() address not valid");
				return false;	
			}
		}
		public function addRecipients($addresses) {
			if (!is_array($addresses)) {
				$addresses = explode(",",$addresses);
			}
			foreach ($addresses as $address) {
				$this->addRecipient(trim($address));

			}
		}
		
		public function setReplyTo($address, $name = null){
			$this->replyto_address = $address;
		}
		public function send() {
			$flag = false;
			if (get_configuration_param("mail_component") == "PHPMAILER") {
				if (!class_exists("PHPMailer")) {
					include_once($_SERVER["DOCUMENT_ROOT"]."/frontbase/lib/phpmailer/class.phpmailer.php");
				}
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->SMTPAuth = $this->mail_smtp_auth;
				$mail->SMTPSecure = $this->mail_smtp_hostprefix; 
				$mail->Host = $this->mail_smtp_hostname;
				$mail->Port = $this->mail_smtp_port;
				$mail->Username = $this->mail_smtp_username;
				$mail->Password = $this->mail_smtp_password;
				$mail->From = $this->from_address;
				$mail->FromName = $this->from_name;
				$mail->Subject = $this->subject;
				
				if (not_empty($this->replyto_address)) {
					$mail->AddReplyTo($this->replyto_address);
				}
				
				if (not_empty($this->plain_body)) {
					$mail->AltBody = $this->plain_body; 
				}
				else {
					Logger::warn("will not send AltBody");
				}
				$mail->WordWrap = 50; // set word wrap
				$mail->MsgHTML(eregi_replace("[\]",'',$this->body));
				$mail->IsHTML(true); // send as HTML
				
				if(isset($this->attachment_path)) {
					$mail->AddAttachment($this->attachment_path);
				}

				if (not_empty($this->recipients["TO"])) {
					foreach ($this->recipients["TO"] as $recipient) {
						$mail->AddAddress($recipient);
					}
					if (is_array($this->recipients["CC"])) {
						foreach ($this->recipients["CC"] as $recipient) {
							$mail->AddCC($recipient);
						}
					}
					if (is_array($this->recipients["BCC"])) {
						foreach ($this->recipients["BCC"] as $recipient) {
							$mail->AddBCC($recipient);
						}
					}
					if(!$mail->Send()) {
						Logger::error("Mailer Error: " .$mail->ErrorInfo);
					  return false;
					} else {
					  $flag = true;	
					}
				}
				else {
					//echo "maybe no recipients?";
					return false;
				}
			}
			else {
				// TODO: implementar CC, BCC?
				$headers = 'From: '.$this->from_name.' <'.$this->from_address.'>'. "\r\n".
					'Reply-To: ' . $this->replyto_address . "\r\n" .
					'Content-Type: text/html; charset=UTF-8' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

					
					foreach ($this->recipients["TO"] as $recipient) {
							if (!mail($recipient, $this->subject, $this->body, $headers))
								return false;
							else
								$flag = true;
					}

			}
			return $flag;
		}
		public function debug() {
			debug($this);
		}
	}
	