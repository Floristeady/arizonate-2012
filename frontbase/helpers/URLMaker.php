<?

class URLMaker {
	
	function replace_accents($s) {
		$s = htmlentities($s);
		$s = preg_replace ('/&([a-zA-Z])(uml|acute|grave|circ|tilde|cedil|ring);/', '$1', $s);
		$s = html_entity_decode($s);
		return $s;
	}


	function fromText($str) {
		$str = self::replace_accents($str);
		$patterns = array('/\s/', '/[^a-z0-9-]/');
		$replacements = array('-', '');

		$str = self::replace_accents(preg_replace($patterns, $replacements, strtolower($str)));

		$str = str_replace("---", "-", $str);
		$str = str_replace("--", "-", $str);

		return $str;
	}

}