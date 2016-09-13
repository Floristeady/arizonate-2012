<?
class PaginatorHelper {
	function PaginatorHelper($list, $items_per_page = 10, $current_index = null) {
		
		$this->items_per_page = $items_per_page;
		$this->mode = $mode;
		$this->page_parameter_name = $page_parameter_name;
		$this->list = $list;
		
		$this->total_pages = count($this->list) / $this->items_per_page;
		if (isset($current_index)) {
			$this->init($current_index);
		}
		else {
			$this->init($_GET["page"]);

		}
	}
	function getPage() {
	 return $this->page_list;
	}

	function init($index) {
		$this->current_page = $index+1;
		$this->page_list = array();
		$temp_list = $this->list;
		
		$counter = 0;
		while ($item = array_shift($temp_list)) {
			if ($index*$this->items_per_page <= $counter && $counter < (($index*$this->items_per_page)+$this->items_per_page))
				$this->page_list[] = $item;
			$counter++;
		}
		
		return $this->page_list;			
	}
	function getLinks($partial_url = null) {
		$this->partial_url = $partial_url;
		
		$str = "";
		if (count($this->list) > $this->items_per_page ) {
			$str .= "<div class='paginator'>";
			if ($this->current_page > 1) {
				$str .= $this->getLinkToPage($this->current_page-2, "Anterior", "prev");
			}
			for ($i = 0; $i<$this->total_pages ;$i++) {
				if ($this->current_page == ($i+1))
					$str .= "<span class='page'>".($i+1)."</span>";
				else
					$str .= $this->getLinkToPage($i, $i+1, "page");
			}
			if ($this->current_page < $this->total_pages) {
				$str .= $this->getLinkToPage($this->current_page, "Siguiente", "next");
			}
			$str .= "</div>";
		}
		return $str;
	}

	function getLinkToPage($index, $text , $class) {
		
		$p = $_GET;
		unset($p["URI"]);
		unset($p["page"]);
		
		if (is_null($this->partial_url))
			$uri = get_requested_uri();
		else
			$uri = $this->partial_url;
		
		if ($index != 0) {
			$parameters = "page=$index";
			foreach ($p as $key => $value) {
				$parameters .= "&".$key."=".$value;
			}
			$parameters = "?".$parameters;
		}
		if (!is_null($this->partial_url)) {
			$parameters  = substr($parameters, 1, strlen($parameters));
		}
		
		if (is_null($this->partial_url)) {
			return "<a class='$class' href=\"/".$uri.$parameters."\">".$text."</a>";
		}
		else {
			$javascript = "\$.ajax({
				type: 'GET',
				url: '".$this->partial_url."',
				data: '$parameters',
				success: function(msg){\$('#List').html(msg);}
			});";
			return "<a class='$class' href='#' onclick=\"".$javascript."\">".$text."</a>";
		}		
	}
}