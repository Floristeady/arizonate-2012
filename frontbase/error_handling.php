<?
	function error_screen($title, $description) {
?>
<body>
	<head>
		<title>Error del Sistema</title>
		<style>
			body {
				font-family: arial;
				}
			h1, h2 {
				margin: 0px;
				margin-bottom: 10px;
				}
				h1 {
					font-size: 17px;
					}
				h2 {
					font-size: 15px;
					}
					p {
					font-size: 12px;	
						}
		</style>
	</head>	
	<body>
		
		<div style=" padding: 4px; margin: 4px; border-color: 1px solid #c1c1c1;">
			<h1>Error del Sistema</h1>
			<h2><?=$title?></h2>
			<p>
				<?=$description?>
			</p>
			
		</div>
		
	</body>
</html>		

<?

	}
	function error_handler($errno, $errstr, $errfile, $errline) {
		if (error_reporting() > 0) {
			$message = "<div style='background-color: black; color: white; padding: 2px;'>$errfile line $errline</div> $errstr";
	    switch ($errno) {
	    case E_ERROR:
	        error_screen("FATAL", $message);
	        exit(1);
	        break;
	    case E_WARNING:
	        error_screen("WARNING", $message);
	        exit(1);
	        break;
	    case E_PARSE:
	        error_screen("PARSE", $message);
	        exit(1);
	        break;
	    case E_NOTICE :
					//DO NOTHING
	        break;
	    default:
	        break;
	    }
	    return true;
  	}
	}
	//set_error_handler('error_handler');
	