<?
	class PassportControl {
		function is_allowed() {
			return (Session::get("access_ok") == true);
		}
		function authenticate($username, $password) {
			if (strlen($username) > 0 && strlen($password) > 0) {
				if (get_configuration_param("password_encryption") == "SHA1") {
					$password = sha1($password);
				}
				if (get_configuration_param("passports_source") == "LDAP") {
					// IMPORTANT: username and password blank will bind as anonymous! (validate this before)
					if ($user = self::against_ldap($username, $password)) {
						Session::set("user", $user);
						return true;
					}
				}
				elseif (get_configuration_param("passports_source") == "CONFIG") {
					return self::against_config($username, $password);
				}
				elseif (get_configuration_param("passports_source") == "DB") {
					if ($user = self::against_db($username, $password)) {
						Session::set("user", $user);
						return true;
					}
					else {
						return false;
					}
				}
			}
			else {
				Logger::warn("No passwords were recieved");
				return false;
			}
		}
		function authenticate_and_allow($username, $password) {
			if (self::authenticate($username, $password)) {
				Session::set("access_ok", true);
				return true;
			}
			else {
				return false;
			}
				
		}
		
		function against_ldap($username, $password){

			$ldapconn = ldap_connect(get_configuration_param("ldap_server_primary"), get_configuration_param("ldap_server_port"));
			ldap_set_option($ldapconn,LDAP_OPT_PROTOCOL_VERSION,3);
			if(!$ldapconn)
				return false;

			invoque_hook("filter_username_for_ldap_bind", $username);

			if (@ldap_bind($ldapconn, $username, $password)) {
				if (strlen(get_configuration_param("user_class")) > 0) {
					$user_class = get_configuration_param("user_class");
				}
				else {
					$user_class = "User";
				}

				/*
					 Especificos de POCH
				*/
				$dn = "ou=corporativo,dc=poch,dc=corp";
				invoque_hook("filter_username_for_ldap_search", $username);
				$filter="(userprincipalname=".$username."*)";

				$result = ldap_search($ldapconn,$dn, $filter);  
				$info = ldap_get_entries($ldapconn, $result);
			
				$user = new $user_class();
				$user->username = $username;
				$user->name = $info[0]["cn"][0];
				$user->email = $info[0]["mail"][0];
				$user->givenname = $info[0]["givenname"][0];
				/*
					 user_entry Deberia ser un campo estandar con todos los keys/values del usuario encontrados en su entry?
				*/	
				foreach ($info[0] as $key => $field) {
					if (is_array($field)) {
						$user->user_entry[$key] = $field[0];
					}	
				}
				ldap_close($ldapconn);
				return $user;	
			}
			else {
				if (get_env() == "development") {
					Logger::warn("Could not sign in PassportControl::against_ldap()");
				}
				return false;
			
			}
		}
		function against_config($username, $password) {
			if ($username == get_configuration_param("restricted_username") && $password == get_configuration_param("restricted_password")) {
				return true;
			}
			else {
				if (get_env() == "development") {
					Logger::warn("Could not sign in against_config::PassportControl");
				}
				return false;
			}
			
		}
		function against_db($username, $password) {
			// TODO: implementar UserClass en SESSION
			
			if (strlen(get_configuration_param("restricted_db_table"))>0)
				$table = get_configuration_param("restricted_db_table");
			else
				$table = "users";

			if (strlen(get_configuration_param("restricted_db_username_field"))>0)
				$username_field = get_configuration_param("restricted_db_username_field");
			else 
				$username_field = "username";
	
			if (strlen(get_configuration_param("restricted_db_pw_field"))>0)
				$password_field = get_configuration_param("restricted_db_pw_field");
			else
				$password_field = "password";
		
			$sql = "SELECT * FROM ".$table." 
			WHERE ".$username_field." = '".mysql_real_escape_string($username)."' 
			AND ".$password_field." = '".mysql_real_escape_string($password)."'";

			if (strlen(get_configuration_param("user_class")) > 0) {
				$user_class = get_configuration_param("user_class");
			}
			else {
				$user_class = "User";
			}

			if ($result = mysql_query_door($sql)) {
				if($user = mysql_fetch_object($result, $user_class)) {
					return $user;
				}
				return false;
			}
			else {
				// Asegurarse que por ningun motivo se filtre esta información en un sitio test o production
				if (get_env() == "development") {
					Logger::error("ERROR on query PassportControl::against_db", $sql);
				}
				return false;
			}
			

			
		}
		
		function logout() {
			Session::set("access_ok", false);
		}
	}