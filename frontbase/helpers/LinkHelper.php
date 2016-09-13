<?

class LinkHelper {

	function add_to_current($params) {
			$str = $_SERVER["REQUEST_URI"];
			

			$str = substr($str, 0, strpos($str, "?"));
			
			$params = array_merge($_GET, $params);
			foreach ($params as $key => $param) {
				if ($key != "URI") {
					$params_txt[] = $key."=".$param;
				}
			}
			$params_query = implode("&", $params_txt);
			
			$url = $str."?".$params_query;
			
			return $url;			
			//return
	}
}