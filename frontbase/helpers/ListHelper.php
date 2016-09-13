<?
class ListHelper {
	
	static function printSeparatedCommas($list, $attribute_name = "name") {
		echo self::separatedBy($list, $attribute_name);
	}
	static function as_list($list, $property, $mode = ",") {
		return self::separatedBy($list, $property, $mode);
	}
	static function separatedBy($list, $attribute_name = "name", $by = ", ") {
		$first = true;
		$str = "";
		if (is_array($list)) {
			foreach ($list as $item) {
				if (!$first)
				$str .= $by;
				if (is_object($item))
					$str .= $item->$attribute_name;
				else
					$str .= $item[$attribute_name];
				$first = false;
			}
		}
		return $str;
	}
	static function group_by($list, $group_by, $callback = null) {
		$glist = array();
		foreach ($list as $content) {
		
			if (is_null($callback)) {
				$value = $content->$group_by;
			}
			else {
				$value = call_user_func($callback, $content->$group_by);
			}
			if (!isset($glist[$value]))
				$glist[$value] = array();
			$glist[$value][] = $content;
		}
		return $glist;
	}
	static function sort($list, $criteria) {
		/*
		Helper para Sorting sin SQL
		ListHelper::sort($list, array("property1 DESC", "AC_Property"))
		ListHelper::sort($list, "property1 DESC")
		*/
		if (!is_array($criteria) && not_empty($criteria)) {
			$criteria = explode(",", $criteria);	
		} 
		foreach($criteria as $c) {
			$e = explode(" ", trim($c));
			$property = $e[0];
			$order = $e[1];
			$ordered = true;
			while($ordered) {
				$ordered = false;
				for ($i = 0; $i < (count($list)-1); $i++) {
					$i1 = $list[$i];
					$i2 = $list[$i+1];
					if ($order != "DESC")
						$cmp_cond = ($i1->$property > $i2->$property);
					else
						$cmp_cond = ($i1->$property < $i2->$property);
					if ($cmp_cond && (!isset($last_property) || $i1->$last_property == $i2->$last_property) ) {
						$item_aux = $list[$i+1];
						$list[$i+1] = $list[$i];
						$list[$i] = $item_aux;
						$ordered = true;					
					}
				}
			}
			$last_property = $property;
		}
		return array_filter($list);
	}



}