<?
	class FileHelper {

		static function get_extension($file_name) {
			return strtolower(substr(strrchr($file_name, '.'), 1));
		}