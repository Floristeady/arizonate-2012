<?
class TextHelper {
	private function shorten_no_breaks($string='',$chars, $elli){
		list($new_string, $elli)= explode("\n", wordwrap($string, $chars, "\n", false));
		return  ( $elli ) ? $new_string.'...' : $new_string;
	}	
	static function shorten($text, $chars = 80, $avoid_breaking_words = true, $elli='...') {
			if ($avoid_breaking_words)
				return self::shorten_no_breaks($text, $chars, $elli);
			else
				return substr($this->comments,0,25).$elli;
	}
	static function new_line() {
		return "\n";
	}
	static function shorten_and_clean($text, $chars = 80, $avoid_breaking_words = true, $elli='...') {
		return self::clean(TextHelper::shorten($text,$chars,$avoid_breaking_words,$elli), "");
	}
	static function clean($text, $allow = "<p><br><strong><b><h1><h2><h3>") {
		return strip_tags($text, $allow );
	}
	static function to_plain($text) {
		return self::clean($text, "");
	}
	static function no_accents($text) {
		return strtr($text,
			'àáâãäçèéêëìíîïñòóôõöùúûüıÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜİ',
			'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'); 	
	}
}