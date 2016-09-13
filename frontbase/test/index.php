<?


class TestUnit {
	function TestUnit($name) {
		//echo $name."<br>";
		$this->name = $name;
	 	$this->results = array();
	 	$this->passed = true;
	}
	function addResult($ok, $r){
		$this->results[] = array("status" => $ok, "message" => $r);
		if (!$ok) {
			$this->passed = false;
		}
	}
	function get_output(){
		if ($this->passed)
			$str = "<div class='test test-ok'>";
		else
			$str = "<div class='test test-error'>";

		$str .= "<h2>".$this->name."</h2>";
			$str .= "<div class='results'>";

		foreach($this->results as $r) {
			if ($r["status"])
				$str .= "<div class='result result-ok'>".$r["message"]."</div>";
			else
				$str .= "<div class='result result-error'>".$r["message"]."</div>";
		}
		$str .= "</div>";
		
		$str .= "</div>";
		return $str;
	}
	
}

class Test {

	function test_memory_limit($mb = 64) {
		$tu = new TestUnit(__FUNCTION__);
		$memory_limit = ini_get('memory_limit');
		if($memory_limit == "-1" || empty($memory_limit) ) {
			$tu->addResult(true, "memory_limit enabled, but set to unlimited");
		}
		else {
			$mem_display = $memory_limit;
			rtrim($memory_limit, 'M');
			$memory_limit_int = (int) $memory_limit;
			if($memory_limit_int < $mb) {
				$tu->addResult(false, "memory_limit must be over $mb, but set to unlimited");
			}
			else {
				$tu->addResult(true, "memory_limit set to $memory_limit_int");
			}
		}
		return $tu;
	
	}
	function test_dirs($dirs, $check_writable = true) {
		$tu = new TestUnit(__FUNCTION__);
		foreach ($dirs as $dir) {
			if (file_exists($_SERVER["DOCUMENT_ROOT"].$dir) ) {
				if (is_writable($_SERVER["DOCUMENT_ROOT"].$dir) || !$check_writable) {
					$tu->addResult(true, "$dir RW Ok");
				} else {
					$tu->addResult(false, "$dir RW not OK");
				}
			}
			else {
				$tu->addResult(false, "$dir doesnt exists");
			}
		}
		return $tu;
	}
}
class PortalPadTest extends Test {
	function test_deny_access() {
/*
Como no se sabe si tiene Deny from All, entonces restringir acceso
*/
		$tu = new TestUnit(__FUNCTION__);
		if (file_exists($_SERVER["DOCUMENT_ROOT"]."/site/portalpad_upload")) {
			$file_name = $_SERVER["DOCUMENT_ROOT"]."/site/portalpad_upload/.htaccess";
			$content = "order allow,deny\ndeny from all";
			$file = fopen($file_name, 'w') or die("can't open file");
			fwrite($file, $content);
			fclose($file);
			$tu->addResult(true, "writen");
		}
		else
			$tu->addResult(true, "doesn exists");
			
		return $tu;

	}
	function test_php_version() {
		$tu = new TestUnit(__FUNCTION__);

		if (version_compare(PHP_VERSION, '5.0.4') != -1) {
			if (version_compare(PHP_VERSION, '5.2.6') != -1) {
				$tu->addResult(true, "php up to date (".PHP_VERSION.")");
			}
			else {
				$tu->addResult(true, "we reccommend updating your php version");
			}
		}
		else {
			$tu->addResult(false, "php must be 5.0.4 or greater (5.2.6 reccommended)");
		}
		return $tu;
	}
	function test_dirs() {
		$dirs = array();
		$dirs[] = "/site/portalpad_upload/";
		$dirs[] = "/site/cache/";
		$dirs[] = "/site/form_backup/";
		$dirs[] = "/site/store/";
		$dirs[] = "/portalpad/system/logs/";
		$dirs[] = "/portalpad/";

		return parent::test_dirs($dirs, true);
	}
	function test_gd() {
		$tu = new TestUnit(__FUNCTION__);

		if (function_exists(gd_info)) { 
			$tu->addResult(true, "GD installed");
		} else {
			$tu->addResult(false, "GD installed");
		} 
		return $tu;
	}
	function test_mod_rewrite_installed() {
		$tu = new TestUnit(__FUNCTION__);
		if (in_array("mod_rewrite", apache_get_modules())) {
			$tu->addResult(true, "mod_rewrite loaded");
		} else {
			$tu->addResult(false, "mod_rewrite not loaded");
		}
		return $tu;

	}
	function test_mysql_connect() {
		$tu = new TestUnit(__FUNCTION__);
		if(mysql_connect (get_db_param("host"), get_db_param("user"), get_db_param("pw"))) {
			if (mysql_select_db(get_db_param("db"))) {
				$tu->addResult(true, "Conection OK");
			}
			else {
				$tu->addResult(false, "Mysql host found but could not select detabase");
			}

		}
		else {
			$tu->addResult(false, "Mysql could not connect to MySQL server");
		}
		return $tu;

		
	}
	function test_env() {
		$tu = new TestUnit(__FUNCTION__);
		$tu->addResult(true, get_env());
		return $tu;
	}
	function test_memory_limit() {
		return parent::test_memory_limit(128);
	}
	function test_display_errors() {
		$tu = new TestUnit(__FUNCTION__);
		if (ini_get("error_reporting") == 6135 && ini_get("display_errors") == 1) {
			$tu->addResult(true, "Error reporting OK");
		}
		else {
			$tu->addResult(false, "No Error reporting");
		}
		return $tu;

	}
	
}

function run_test($test_class_name) {
	foreach (get_class_methods($test_class_name) as $method_name) {
		$object = new $test_class_name();
		$tu = call_user_func(array($object, $method_name));
		$output .= $tu->get_output();
	}
	
	return $output;
}




?>

<html>
	
<head>

<style>
* { font-family:tahoma; font-size: 11px; font-weight: normal; }
h1 {font-size: 17px;}
h2 {margin: 0px; width: 200px; float:left;	margin: 3px; }
.test {

	margin: 2px; 
	padding: 0px;
	float:left; 
	clear: both; 
}

.test-ok {
	border: 1px none #808080; 
	background-color: #eaeaea; 	
}

.test-error {
	border: 1px none #808080; 
}
.results {
	width: 300px; 
	float:left;
	
}
.result{padding: 4px; }
.result-ok { color: green; }
.result-error {	background-color: #AA0004;	color: white; 	

}

</style>
</head>
<body>
	<h1>Test</h1>
	
	
	<?=run_test('PortalPadTest');?>
</body>
</html>
