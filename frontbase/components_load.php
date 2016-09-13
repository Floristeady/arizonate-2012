<?

	



	$to_load = array();
	if (count(get_configuration_param("load_sites_models"))>0) {
		foreach (get_configuration_param("load_sites_models") as $site) { 
			if (get_current_site_space() != $site) { 
				$to_load[] = $site;
			}
		}
	}

	$to_load[] = get_current_site_space();
	foreach ($to_load as $site_space) {
		Logger::benchmark("will look for models in $site_space ",(microtime(true) - $benchmark_start));

		$components = array();
		$components_dir = $_SERVER["DOCUMENT_ROOT"]."/sites/".$site_space."/components/";
		if (file_exists($components_dir)) {
			if ($handle = opendir($components_dir)) {
				while (false !== ($component_file = readdir($handle)) ) {
					if ($component_file != "." && $component_file != ".." && !is_dir($components_dir.$component_file)) {
						$components[] = $component_file;

						include($components_dir.$component_file);

					}
				}
			}
		}

	
		$models = array();
		$models_dir = $_SERVER["DOCUMENT_ROOT"]."/sites/".$site_space."/models/";
		if (file_exists($models_dir)) {
			if ($handle = opendir($models_dir)) {
				while (false !== ($model_file = readdir($handle)) ) {
					if ($model_file != "." && $model_file != ".." && !is_dir($models_dir.$model_file)) {
						$models[] = $model_file;
						require_once($models_dir.$model_file);
						
						$object_name = current(explode(".",$model_file));
						
						if (array_key_exists("table_name", get_class_vars($object_name))) {
							eval("\$defined_table_name = ".$object_name."::\$table_name;");
						}
						if (strlen($defined_table_name) > 0) 
							$object_table = $defined_table_name;
						else
							$object_table = strtolower($object_name)."s";
						
						if (!is_array(get_class_vars($object_name)))
							Logger::error("There's a problem with the Model File, maybe you misspelled the Model for <".$object_name.">");
							
						if (array_key_exists("plural", get_class_vars($object_name))) {
							eval("\$defined_plural = ".$object_name."::\$plural;");
						}
						$order_by = "";
						if (array_key_exists("order_by", get_class_vars($object_name))) {
							eval("\$order_by = ".$object_name."::\$order_by;");
						}
						if (strlen($defined_plural) > 0) 
							$plural = $defined_plural;
						else
							$plural = strtolower($object_name)."s";
	
						$soft_deletion = false;
						if (array_key_exists("soft_deletion", get_class_vars($object_name))) {
							eval("\$soft_deletion = ".$object_name."::\$soft_deletion;");
						}

						$models[$object_name] = array("table_name" => $object_table);
						$models["by_plural"][$plural] = array("model" => $object_name);
						
						$defined_table_name = null;
						$defined_plural = null;
	
						$class_code = "
							class ".ucwords($object_name)."Tool extends PortalDataObjectTool {
								public \$table = '".$object_table."';
								public \$plural = '".$plural."';
								public \$soft_deletion = ".(($soft_deletion)?"true":"false").";
								public \$object_name = '".ucwords($object_name)."';
								public \$order_by = '".$order_by."';
							} ";
						eval($class_code);
						
						
						if (class_exists(ucwords($object_name)."Tool")) {
							Logger::info("<".$object_name."> Model successfully loaded");
						}
					}
	
	
				}
			}
		}
	}

	if (!class_exists("User")) { 
		class User {
			
		}
	}



	function get_classes() {
		$classes["AjaxHelper"] = "helpers/AjaxHelper";
		$classes["AttachmentHelper"] = "helpers/AttachmentHelper";
		$classes["BasicHelper"] = "helpers/BasicHelper";
		$classes["CalendarListHelper"] = "helpers/CalendarListHelper";
		$classes["CountryListHelper"] = "helpers/CountryListHelper";
		$classes["DateHelper"] = "helpers/DateHelper";
		$classes["FileHelper"] = "helpers/FileHelper";
		$classes["FlashHelper"] = "helpers/FlashHelper";
		$classes["FlashMessageHelper"] = "helpers/FlashMessageHelper";
		$classes["FlashMessage"] = "FlashMessage";
		$classes["FormHelper"] = "helpers/FormHelper";
		$classes["HeadHelper"] = "helpers/HeadHelper";
		$classes["htmLawed"] ="lib/htmLawed/htmLawed";
		$classes["ImageProcessor"] ="lib/ImageProcessor";
		$classes["ListHelper"] = "helpers/ListHelper";
		$classes["LinkHelper"] = "helpers/LinkHelper";
		$classes["Map"] = "Map";
		$classes["MapHelper"] = "helpers/MapHelper";
		$classes["MailHelper"] ='modules/MailHelper';
		$classes["ModelFormHelper"] = "helpers/ModelFormHelper";
		$classes["PaginatorHelper"] = "helpers/PaginatorHelper";
		$classes["PassportControl"] ="PassportControl";
		$classes["ScaffoldController"] ="ScaffoldController";
		$classes["SimpleBreadcumbHelper"] = "helpers/SimpleBreadcumbHelper";
		$classes["TagHelper"] = "helpers/TagHelper";
		$classes["TextHelper"] = "helpers/TextHelper";
		$classes["TreeHelper"] ='helpers/TreeHelper';
		$classes["URLMaker"] = "helpers/URLMaker";
		$classes["SearchTool"] = "SearchTool";
		$classes["ValidationTool"] ='ValidationTool';
		$classes["NumberHelper"] ='helpers/NumberHelper';

		$classes["JavascriptPluggin"] ='JavascriptPluggin';


		if (!(get_configuration_param("portalpad_api_version") == "2")) {
			$classes["MenuItem"] = "portalpad/1/MenuItem";
			$classes["PFile"] = "portalpad/1/PFile";
			$classes["Attribute"] = "portalpad/1/Attribute";
			$classes["AttributeTool"] = "portalpad/1/AttributeTool";
			$classes["AttachedFile"] = "portalpad/1/AttachedFile";
			$classes["Banner"] = "portalpad/1/Banner";
			$classes["BreadCumbTool"] = "portalpad/1/BreadCumbTool";
			$classes["Comment"] = "portalpad/1/Comment";
			$classes["Content"] = "portalpad/1/Content";
			$classes["ContentTool"] = "portalpad/1/ContentTool";
			$classes["FileTool"] = "portalpad/1/FileTool";
			$classes["PImage"] = "portalpad/1/PImage";
			$classes["PFile"] = "portalpad/1/PFile";
			$classes["ImageTool"] = "portalpad/1/ImageTool";
			$classes["SectionMenu"] = "portalpad/1/SectionMenu";
			$classes["Section"] = "portalpad/1/Section";
			$classes["SectionTool"] = "portalpad/1/SectionTool";
			$classes["TaxonomyTerm"] = "portalpad/1/TaxonomyTerm";
			$classes["TaxonomyTermTool"] = "portalpad/1/TaxonomyTermTool";
			$classes["TaxonomyTypeTool"] = "portalpad/1/TaxonomyTypeTool";
			$classes["TaxonomyType"] = "portalpad/1/TaxonomyType";
			$classes["Type"] = "portalpad/1/Type";
			$classes["TypeTool"] = "portalpad/1/TypeTool";
		}


		return $classes;
	}
	

	
	function __autoload($class_name) {
		$classes = get_classes();

		if (isset($classes[$class_name])) {
			require($classes[$class_name].'.php');
		}
		
	}

