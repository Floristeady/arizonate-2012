<?

class Map {
	function __construct($unique_id = null) {
		if (is_null($unique_id)) {
			$this->unique_id = $unique_id;
		}
		else {
			$this->unique_id = "default";
		}
		
		$this->zoom = 13;
		$this->points = array();
		$this->center_latitude = 0;
		$this->center_longitude = 0;
	}
	public function addPoint($arg1, $arg2 = null, $info = null) {
		if (get_class($arg1) == "Point") {
			$point = $arg1;
		}
		else {
			$point = new Point($arg1, $arg2, $info);
		}
		$this->points[] = $point;
		$this->calculateCenter();
	}
	private function calculateCenter() {
		$sum_latitude = 0;
		$sum_longitude = 0;
		foreach ($this->points as $point) {
			$sum_latitude = $point->latitude + $sum_latitude;
			$sum_longitude = $point->longitude + $sum_longitude;
		}
		if (count($this->points) > 0) {
			$this->center_latitude = $sum_latitude/count($this->points);
			$this->center_longitude = $sum_longitude/count($this->points);
		}
	}
	public function setZoom($zoom = 13) {
		$this->zoom = $zoom;
	}
}
class Point {
	function __construct($latitude, $longitude, $info = null) {
		$this->latitude = $latitude;
		$this->longitude = $longitude;
		$this->info = $info;
	}
	
}
class PointInfo {
	
	

}