<?
/*
	USAGE: treeHelper(object)
	Donde bject debe implementar getChildren()
*/

class TreeHelper {
	function TreeHelper($seed) {
		$this->seed = $seed;
		$this->order_by  = "weight,name";
	}
	function setLink_callBack($callback) {
		$this->link_callBack = $callback;
	}
	function setOrderBy($order_by) {
		$this->order_by = $order_by;
	}
	function output($deepness = 0, $override_seed = null) {
		if (is_null($override_seed)) {
			$seed = $this->seed;
		}
		else {
			$seed = $override_seed;
		}
		

		$str .= "<ul class='children' id='children_".$seed->id."'>";

		foreach (ListHelper::sort($seed->getChildren(), $this->order_by) as $item) {
			$str .= "<li id='category_".$item->id."' class='checktree-item-deep-".$deepness."'>";
			if (isset($this->link_callBack)){
				$call_back = $this->link_callBack;
				$str .= "<a href='".call_user_func(array($item,$call_back))."'>".$item->name."</a>";
			}else {
				$str .= $item->name;
			}
			
			$str .= "</li>";

			$str .= $this->output($deepness+1, $item);
			
		}
		$str .= "</ul>";
	
		return $str;
	
	
	}
	
	
	
}