<?

	class SectionMenu {
		function SectionMenu() {
			$this->display_not_expanded = true;
			$this->class_not_expanded = "oculto";
			$this->expand_all = false;
			$this->prefix_class_ul = "menu_depth_";
		}
		function generateHTML($parent_section_id, $hidden = false) {
			$parent_section = SectionTool::fetch($parent_section_id);
			$str = "";
			if ($hidden) {
				$str .= "<ul id='menu_s_$parent_section->id' class='".$this->prefix_class_ul.$parent_section->depth." $this->class_not_expanded'>";
			}
			else {
				$str .= "<ul class='".$this->prefix_class_ul."$parent_section->depth'>";
			}
			if ($parent_section->menu_expand_contents == 1) {
				$ct = new ContentTool();
				$ct->addCondition(array("type" => "section", "value" => $parent_section->id));
				$ct->promoted = false;
				foreach ($ct->fetch_list() as $content) {
					if ($content->expands())
						$events = "";
					else
						$events = "";
					
					$class_active = "";
					if (isset($this->current_content)) {
						if ($this->current_content->id == $content->id || $this->current_content->isChildrenOf($content)) {
							$class_active .= "selected";
						}
					}

						
					$str .= "<li><a class='$class_active' $events href='".$content->getItemLink()."' >".$content->getT('title')."</a></li>";

 					if ($parent_section->menu_expand_related == 1) {
 						if (!$this->expand_all) {
	 						if (isset($this->current_content)) {
	 							$expand_this = $this->current_content->isChildrenOf($content) || $this->current_content->id == $content->id;
	 						} else {
	 							$expand_this = false;
	 						}	
	 					}
 						else {
 							$expand_this = true;
 						}
 						
						if (!$expand_this && $this->display_not_expanded)
	 						$str .= "<ul id='menu_c_".$content->id."' class='$this->prefix_class_ul".($parent_section->depth + 1)."  $this->class_not_expanded'>";
						else
 							$str .= "<ul id='menu_c_".$content->id."' class='$this->prefix_class_ul".($parent_section->depth + 1)."'>";
 						
 						
 						if ($expand_this || $this->display_not_expanded) {
		 					foreach ($content->getChildren() as $content_related) {

								$class_active = "";
								if ($this->current_content->id == $content_related->id) {
									$class_active .= "selected";
								}
		 						
		 						$str .= "<li><a class='$class_active' href='".$content_related->getItemLink()."'>".$content_related->getT('title')."</a></li>";

		 					}
	 					}
 						$str .= "</ul>";
 					}
				}
			}
			if ($parent_section->menu_expand_children == 1) {
				foreach ($parent_section->getChildren() as $section) {
					if (!$section->menu_exclude) {
						if (!$this->expand_all)
							$expand_this = ($this->current_section->isChildrenOf($section) || $this->current_section->id == $section->id);
						else
							$expand_this = true;
							

						$link = null;
						if ($section->is_node == 1) {
							$link = $section->getItemLink();
						}
						else {
							if ($first_child = $section->getFirstChild())
								$link = $first_child->getItemLink();
						}
						if ($section->expands())
							$events = "";
						else
							$events = "";
						
						$class_active = "";
						if ($this->current_section->id == $section->id || $this->current_section->parent->id == $section->id ) {
							$class_active .= "selected";
						}
							
						if (!is_null($link)) {
							$str .= "<li class='menu_item$section->id' ><a $events class='$class_active' href='".$link."'>".$section->getT('name')."</a>";
						} else {
							$str .= "<li class='menu_item$section->id'>".$section->getT('name');
						}
						if ($expand_this || $this->display_not_expanded) {
							$str .= $this->generateHTML($section->id,!$expand_this);
						}
						$str .= "</li>";				
					}
				}
			}

			$str .= "</ul>";
			return $str;
		}
		function getMenuArray($parent_section) {
			$elements = array();

			if ($parent_section->menu_expand_contents == 1) {
				$ct = new ContentTool();
				$ct->addCondition(array("type" => "section", "value" => $parent_section->id));
				$ct->promoted = false;
				foreach ($ct->fetch_list() as $content) {
					$elements[] = $content;		
				}
			}
			foreach ($parent_section->getChildren() as $section) {
				if (!$section->menu_exclude ) {
					$elements[] = $section;	
				}
			}
			return $elements;	
		}
		
		function outputHTML($section_id, $current_section = null, $current_content = null) {
			if (!is_null($current_section)) {
				$this->current_section = $current_section;
			}
			if (!is_null($current_content)) {
				$this->current_content = $current_content;
			}
			echo $this->generateHTML($section_id);
		}
		
	}