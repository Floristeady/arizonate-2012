<?
class NumberHelper {
	public function format_price($n){
		// TODO: Localization
		return "$ ".number_format($n,0,",",".");
	}	

}