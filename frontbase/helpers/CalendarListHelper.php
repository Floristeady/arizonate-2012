<?
	class CalendarListHelper {
	    function CalendarListHelper($list = array(), $date_attribute_name = null, $y = null, $m = null) {
	      if (!isset($m))
	        $m = date("n");
	      if (!isset($y))
	        $y = date("Y");
	      $d= date("d");
	      
	      
	      
	      $this->y = $y;
	      $this->m = $m;
	      $this->d = $d;
	      
	      $this->list = $list;
	      $this->date_attribute_name = $date_attribute_name;
	    }
	    function output() {
	      $str = "";
	      $no_of_days = date('t',mktime(0,0,0,$this->m,$this->d,$this->y)); // This is to calculate number of days in a month
	      $mn=date('M',mktime(0,0,0,$this->m,$this->d,$this->y)); // Month is calculated to display at the top of the calendar
	      $yn=date('Y',mktime(0,0,0,$this->m,$this->d,$this->y)); // Year is calculated to display at the top of the calendar
	      $j= date('w',mktime(0,0,0,$this->m,1,$this->y)); // This will calculate the week day of the first day of the month
	
	      $m_prev=date('n',mktime(0,0,0,$this->m-1,$this->d,$this->y));
	      $y_prev=date('Y',mktime(0,0,0,$this->m-1,$this->d,$this->y));
	
	      $m_next=date('n',mktime(0,0,0,$this->m+1,$this->d,$this->y));
	      $y_next=date('Y',mktime(0,0,0,$this->m+1,$this->d,$this->y));
	
	
	      
	      if ($j == 0) {
	        $j = 7;
	      }
	      for($k=1; $k<$j; $k++){ // Adjustment of date starting
	        $adj .="<td>&nbsp;</td>";
	      }
	      $r = rand(1000,9999);
	      $div_id = "calendar_".$r;
	      $str .= "
	      		<script>
	      		function showMonth_$r(y, m) {
	      			$('#$div_id').fadeOut(300,function() {
		      			$('#$div_id').load('/main/ajax_calendar_events/' + y + '/' + m, function() {
			      			$('#$div_id a').tooltip({showURL: false});
			      			$('#$div_id').fadeIn(300);
		      			});
	      			});
	      		}
	      		</script>
	      		
	      		<div id='$div_id'>
	          <table class='calendarlist' border='0'>
	          <tr>
	          <td align=center >
	          	<a href='#' onclick='showMonth_$r(". $y_prev.", ".($m_prev).")'><</a>
	          </td>
	          <td colspan=5 align=center >$mn $yn </td>
	          <td align=center >
	          	<a href='#' onclick='showMonth_$r(". $y_next.",".($m_next).")'>></a>
	          </td>
	          </tr>
	          <tr>";
	      $str .= "<td>Lun</td><td>Mar</td><td>Mie</td><td>Jue</td><td>Vie</td><td>Sab</td><td>Dom</td></tr><tr>";
	      for($i=1;$i<=$no_of_days;$i++){
	        $elements = $this->getElementsForDay($i);
	        
	        if (date("d") == $i)
	       		$str .= $adj."<td class='today'>";
	        else
	        	$str .= $adj."<td>";
	        
	        if ($first = current($elements)) {
	        	$link = $first->getItemLink();
	          $tips = $this->array_map_objects("getPublicName", $elements);
	        	$tip_text = implode(", ", $tips);      
	          $str .= "<a id='day' href='$link' title='".$tip_text."'>$i</a>";
	        }
	        else {
	          $str .= "$i";
	        }
	        $str .= " </td>";
	        $adj='';
	        //echo $j;
	        if($j==7){
	          $str .= "</tr><tr>";
	          $j=0;
	        }
	        $j ++;
	      }
	      $str .= "</tr></table></div>";
	      return $str;
	    }
	    function array_map_objects($member_function, $array) {
	    $values = array();
	
	    if(is_string($member_function) && is_array($array)) {
	        $callback = create_function('$e', 'return call_user_func(array($e, "' . $member_function .'"));');
	        $values = array_map($callback, $array);
	    }
	
	    return $values;
			}
	    function getElementsForDay($d) {
	      $list = array();
	      foreach ($this->list as $element) {
	        $date_attribute_name = $this->date_attribute_name;
	        if (date('d', $element->$date_attribute_name) == $d && date('n', $element->$date_attribute_name) == $this->m && date('Y', $element->$date_attribute_name) == $this->y) {
	          $list[] = $element;
	        }
	      }
	      return $list;
	    }
	}