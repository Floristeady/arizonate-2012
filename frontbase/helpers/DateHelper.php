<?

class DateHelper {
	static function getMonths() {
		$months = array();
		$months[1]["es"] = "Enero";
		$months[2]["es"] = "Febrero";
		$months[3]["es"] = "Marzo";
		$months[4]["es"] = "Abril";
		$months[5]["es"] = "Mayo";
		$months[6]["es"] = "Junio";
		$months[7]["es"] = "Julio";
		$months[8]["es"] = "Agosto";
		$months[9]["es"] = "Septiembre";
		$months[10]["es"] = "Octubre";
		$months[11]["es"] = "Noviembre";
		$months[12]["es"] = "Diciembre";
		
		$months[1]["en"] = "January";
		$months[2]["en"] = "February";
		$months[3]["en"] = "March";
		$months[4]["en"] = "April";
		$months[5]["en"] = "May";
		$months[6]["en"] = "June";
		$months[7]["en"] = "July";
		$months[8]["en"] = "August";
		$months[9]["en"] = "September";
		$months[10]["en"] = "October";
		$months[11]["en"] = "November";
		$months[12]["en"] = "December";
		
		return $months;
	}
	static function getDaysOfWeek() {
		$dow = array();
		$dow[1]["es"] = "Lunes";
		$dow[2]["es"] = "Martes";
		$dow[3]["es"] = "Miércoles";
		$dow[4]["es"] = "Jueves";
		$dow[5]["es"] = "Viernes";
		$dow[6]["es"] = "Sábado";
		$dow[7]["es"] = "Domingo";
		
		$dow[1]["en"] = "Monday";
		$dow[2]["en"] = "Tuesday";
		$dow[3]["en"] = "Wednesday";
		$dow[4]["en"] = "Thursday";
		$dow[5]["en"] = "Friday";
		$dow[6]["en"] = "Saturday";
		$dow[7]["en"] = "Sunday";
		
		return $dow;
	}
	static function getDayOfWeekName($date_or_number, $lenght = 10) {
		if (0 < $date_or_number && $date_or_number <= 7) {
			$dow_number = $date_or_number;
		}
		else {
			$dow_number = date("N",$date_or_number);
		}
		$dow = self::getDaysOfWeek();
		return substr($dow[$dow_number][get_current_lang()],0,$lenght);
	}
	static function getMonthName($date_or_number, $lenght = 20) { 
		$months = self::getMonths();
		if (0 < $date_or_number && $date_or_number <= 12) {
			$month_number = $date_or_number;
		}
		else {
			$month_number = date("n",$date_or_number);
		}
		return substr($months[$month_number][get_current_lang()],0,$lenght);	
	}
	static function printSelect($prefix = "", $selected_date = null) {
		if (strlen($prefix)>0)
			echo "<select name='".$prefix."[D]'>";
		else
			echo "<select name='D'>";
			
		echo "<option>Dia</option>";
		for ($d = 1; $d <= 31; $d++) {
			if (isset($selected_date) && date('j',$selected_date) == $d) {
				echo "<option value='$d' selected>$d</option>";
			}
			else
				echo "<option value='$d'>$d</option>";
		}
		echo "</select>";	
		
		if (strlen($prefix)>0)
			echo "<select name='".$prefix."[M]'>";
		else
			echo "<select name='M'>";
			
		echo "<option>Mes</option>";
		foreach (DateHelper::getMonths() as $key => $month) {
			if (isset($selected_date) && date('n',$selected_date) == $key)
				echo "<option value='".$key."' selected>".$month[get_current_lang()]."</option>";
			else
				echo "<option value='".$key."' >".$month[get_current_lang()]."</option>";
		}
		echo "</select>";	

		if (strlen($prefix)>0)
			echo "<select name='".$prefix."[Y]'>";
		else
			echo "<select name='Y'>";
			
		echo "<option>Año</option>";
		for ($d = date('Y'); $d >= 1900; $d--) {
			if (isset($selected_date) && date('Y',$selected_date) == $d)
				echo "<option value='$d' selected>$d</option >";
			else
				echo "<option value='$d'>$d</option >";
		}
		echo "</select>";	
	}
	static function print_date($date = null, $format = "NORMAL") {
		if (is_numeric($date)) {
			$months = DateHelper::getMonths();
	
			$month = $months[date("n",$date)][get_current_lang()];
	
			if ($format == "NORMAL")
				echo date("j",$date)." ".$month;
			elseif ($format == "SHORT") 
				echo date("j",$date)." ".substr($month,0,3);
			elseif ($format == "FULL")
				echo date("j",$date)." ".$month." ".date("Y",$date);
			elseif ($format == "SHORT_NO_DAY")
				echo substr($month,0,3)." ".date("Y",$date);
			elseif ($format == "SHORT_WITH_YEAR") 
				echo date("j",$date)." ".substr($month,0,3)." ".date("y",$date);
			elseif ($format == "MONTH_ONLY") {
				echo $month;
			}
		}
	}
	static function get_time($date = null) {
		if (is_numeric($date)) {
			return date("H:i",$date);
		}
	}
	static function print_month_from_number($n) {
		$months = DateHelper::getMonths();
		echo $months[$n][get_current_lang()];
	}
	static function getRangeOfMonth($arg1, $arg2 = null) {
		if (is_null($arg2)) {
			$date = $arg1;
		}
		else {
			$date = strtotime($arg1."-".$arg2."-01");	
		}
		
		$from = strtotime(date("Y-m", $date)."-01");
		$to = strtotime(date("Y-m-t", $date));
		
		return array($from, $to);
	}
}