<?

class BasicHelper {

	function link($url, $name = null, $options = array()) {
		$options["href"] = $url;
		if (is_null($name)) {
			$name = $url;
		}
		$th = new TagHelper("a", $options);
		$th->setContent($name);
		return $th->output();
	}
	
}