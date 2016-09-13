<?
/*
	ARCHIVO DE CONFIGURACION DEL SITIO WEB
	La variable env define el entorno para la configuración del sitio web. Los valores predefinidos son:
	- development: para desarrollo
	- test: para pruebas antes de la publicacion del sitio
	- production: para versión de producción. Los mesnajes de depuración desaparecerán completamente del output, asi como también los errores.
*/
	$env = "development";

	$default_lang = "es";

/*
	Si se implementan los sitespaces por primera vez hay que pasar los contenidos existentes a algún sitespace:
	INSERT INTO contents_sitespaces (content_id, sitespace_id) (SELECT id, 1 FROM contents WHERE id < 334)
*/

  $langs = array();
  $langs[] = "en";
  $langs[] = "es";
	$dmode = "krumo";

/*
	DATABASE
*/

	$db["development"]["host"] = "db-server";
	$db["development"]["user"] = "root";
	$db["development"]["pw"] = "mysqluser";
	$db["development"]["db"] = "portaldata_poch";

	$db["test"]["host"] = "localhost";
	$db["test"]["user"] = "root";
	$db["test"]["pw"] = "";
	$db["test"]["db"] = "portaldata_poch";

	$db["production"]["host"] = "localhost";
	$db["production"]["user"] = "root";
	$db["production"]["pw"] = "";
	$db["production"]["db"] = "web_poch";
/*
	auto_start_session
*/
	$conf_all["auto_start_session"] = true;


/*
	BRIDGING ALLOWED HOSTS
*/
	
	$conf_all["bridge_allowed_host"] = "mystatus.skype.com";
	
/*
	EMAIL

	Valores del PARAMETRO mail_component
		* "PEAR": Utilizar PEAR::MAIL. Los componentes PEAR::SMTP y PEAR::NET deben estar instalados
		* "PHPMAILER": Utilizar PHPMAILER. El componente viene incluido
		* "PHP" o "": Utilizar la funcion mail() de PHP. Solo se permite el uso de los siguientes parametros:
			- mail_from_name
			- mail_from_address
			- *_web_mailbox

	NOTA: Gmail no aceptará para autenticación SMTP contraseñas faciles. Intente algo mas complicado.
*/

	$conf["development"]["mail_component"] = "PHPMAILER";
	$conf["development"]["mail_smtp_hostprefix"] = "ssl";
	$conf["development"]["mail_smtp_hostname"] = "smtp.gmail.com";
	$conf["development"]["mail_smtp_auth"] = true;
	$conf["development"]["mail_smtp_username"] = "test@appnotion.com";
	$conf["development"]["mail_smtp_password"] = "34er34er";
	$conf["development"]["mail_smtp_port"] = "465";
	$conf["development"]["mail_from_name"] = "Web";
	$conf["development"]["mail_from_address"] = "test@appnotion.com";

	$conf["test"]["mail_component"] = "PHPMAILER";
	$conf["test"]["mail_smtp_hostprefix"] = null;
	$conf["test"]["mail_smtp_hostname"] = "mail.poch.cl";
	$conf["test"]["mail_smtp_auth"] = false;
	$conf["test"]["mail_smtp_username"] = "zet@poch.cl";
	$conf["test"]["mail_smtp_password"] = "zet1801";
	$conf["test"]["mail_smtp_port"] = 25;
	$conf["test"]["mail_from_name"] = "Web Poch";
	$conf["test"]["mail_from_address"] = "zet@poch.cl";

	$conf["production"]["mail_component"] = "PHPMAILER";
	$conf["production"]["mail_smtp_hostprefix"] = null;
	$conf["production"]["mail_smtp_hostname"] = "mail.poch.cl";
	$conf["production"]["mail_smtp_auth"] = false;
	$conf["production"]["mail_smtp_username"] = "zet@poch.cl";
	$conf["production"]["mail_smtp_password"] = "zet1801";
	$conf["production"]["mail_smtp_port"] = 25;
	$conf["production"]["mail_from_name"] = "Web Poch";
	$conf["production"]["mail_from_address"] = "zet@poch.cl";

	$conf_all["mail_subject"] = "NO SUBJECT";

	$conf["development"]["forms_input_backup"] = true;
	$conf["test"]["forms_input_backup"] = true;
	$conf["production"]["forms_input_backup"] = true;

/*
	HTML Filter
*/
		$conf["development"]["html_filter_on"] = false;
		$conf["test"]["html_filter_on"] = false;
		$conf["production"]["html_filter_on"] = false;

		$conf["development"]["html_filter_spec"] = "";
		$conf["test"]["html_filter_spec"] = "";
		$conf["production"]["html_filter_spec"] = "";


/*
	Languages Application
*/
		$conf_all["lang_path"] = "";
		$conf_all["lang_app"] = "";

/*
	GMAPS
*/

	$conf["development"]["gmapskey"] = "ABQIAAAAPPaAr86fWL8P3WKmzm1yXRT2yXp_ZAY8_ufC3CFXhHIE1NvwkxTt1Jcz2x9fZMnGoxIxCc8Z9QwAUw";
	$conf["test"]["gmapskey"] = "ABQIAAAAPPaAr86fWL8P3WKmzm1yXRSDJjvVifOvDy8JbPhc_Nox4n5jLRSnkj27iS-KIIr_FtzzhhHxJTjpCA";
	$conf["production"]["gmapskey"] = "ABQIAAAAPPaAr86fWL8P3WKmzm1yXRRcCvUycX7_7589TWv3RK3wH3f3HxR6ih75EuGHUNo3NzKMRuRxiuui4Q";


/*
	IMAGES
*/

	$conf["development"]["use_resize_cache"] = true;
	$conf["test"]["use_resize_cache"] = true;
	$conf["production"]["use_resize_cache"] = true;
	
	//IMPORTANTE: borrar los contenidos de /site/cache para que se aplique jpeg_quality nuevo
	$conf_all["jpeg_quality"] = 100; 
	
	$conf_all["img_rel_path"] = "/site/portalpad_upload/";
	$conf_all["img_resized_path"] = "/site/resized/";
	$conf_all["img_cache_path"] = "/site/cache/";


/*
	INDEXING
*/

	$conf["development"]["robots_index"] = false;
	$conf["test"]["robots_index"] = false;
	$conf["production"]["robots_index"] = true;


/*
	LOGGING
*/

	$conf["development"]["logging_type"] = "FB";
	$conf["test"]["logging_type"] = "";
	$conf["production"]["logging_type"] = "";


	$conf["development"]["logging_level"] = true;
	$conf["test"]["logging_level"] = false;
	$conf["production"]["logging_level"] = false;

/*
	MINIFY
*/

	$conf["development"]["minify"] = true;
	$conf["test"]["minify"] = true;
	$conf["production"]["minify"] = true;
/*
	TEMPLATES
	In use?
*/

		$conf_all["layout_file"] = "main";
		$conf_all["default_page_file"] = "home";
		$conf_all["sublayout_file"] = null;
		
/*
	USER-RESTRICTED
*/

	$conf_site_specific["intranet"]["development"]["https_only"] = false;
	$conf_site_specific["intranet"]["development"]["restricted"] = true;
	$conf_site_specific["intranet"]["development"]["passports_source"] = "CONFIG";
	$conf_site_specific["intranet"]["development"]["ldap_server_primary"] = "127.0.0.1";
	$conf_site_specific["intranet"]["development"]["ldap_server_secondary"] = "127.0.0.1";
	$conf_site_specific["intranet"]["development"]["ldap_server_port"] = 10389;
	$conf_site_specific["intranet"]["development"]["restricted_username"] = "admin";
	$conf_site_specific["intranet"]["development"]["restricted_password"] = "test";
	
	$conf_site_specific["intranet"]["test"]["https_only"] = false;
	$conf_site_specific["intranet"]["test"]["restricted"] = true;
	$conf_site_specific["intranet"]["test"]["passports_source"] = "LDAP";
	$conf_site_specific["intranet"]["test"]["ldap_server_primary"] = "164.77.203.170";
	$conf_site_specific["intranet"]["test"]["ldap_server_secondary"] = "164.77.203.170";
	$conf_site_specific["intranet"]["test"]["ldap_server_port"] = 389;
	
	$conf_site_specific["intranet"]["production"]["https_only"] = true;
	$conf_site_specific["intranet"]["production"]["restricted"] = true;
	$conf_site_specific["intranet"]["production"]["passports_source"] = "LDAP";
	$conf_site_specific["intranet"]["production"]["ldap_server_primary"] = "164.77.203.170";
	$conf_site_specific["intranet"]["production"]["ldap_server_secondary"] = "164.77.203.170";
	$conf_site_specific["intranet"]["production"]["ldap_server_port"] = 389;

	/* 
		Autenticacion contra DB

		$conf_all["passports_source"] = "DB";
		$conf_all["restricted_db_table"] = "users";
		$conf_all["restricted_db_username_field"] = "username";
		$conf_all["restricted_db_pw_field"] = "pw";
		
		$conf_all["scaffold_login_layout"] = null;
		
		login_controller

	*/
	
	

/*
	URLS
*/

	$conf["development"]["friendly_urls"] = true;
	$conf["test"]["friendly_urls"] = true;
	$conf["production"]["friendly_urls"] = true;




/*
	TEMPLATES
*/

	$layout_file = "main";
	$default_page_file = "home";
	$sublayout_file = null;



/*
	NO CERRAR SCRIPT NI INCLUIR NINGUN OUTPUT
	MANTENER EN ASCII
*/
