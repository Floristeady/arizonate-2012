<?
  abstract class Translatable {
 
    function getT($property_name = "description", $force_lang = null, $force_output = true){
      if (!isset($force_lang))
        $output_lang = get_current_lang();
      else
        $output_lang = $force_lang;
      
      if ($output_lang == get_default_lang()) {
        $full_property_name = $property_name;
      }
      else {
        $full_property_name = $property_name."_".$output_lang;
      }

      if (strlen($this->$full_property_name)>0) {
        return $this->$full_property_name;
      }
      elseif ($force_output) {
        return $this->$property_name;
      }
      return null;
    }
    function getLocale($property_name = "description", $force_lang = null, $force_output = true){
    	/*
    	DEPRECAR
    	Quizas es clon del framework antiguo de BCN?
    	*/
    	exit("Translatable::get_locale()");
      if (!isset($force_lang))
        $output_lang = get_current_lang();
      else
        $output_lang = $force_lang;
      
      $full_property_name = $property_name."_".$output_lang;

      if (strlen($this->$full_property_name)>0) {
        return $this->$full_property_name;
      }
      elseif ($force_output) {
      	$property_original_lang = $property_name."_".get_default_lang();
        return $this->$property_original_lang;
      }
      return null;
    }    
  }