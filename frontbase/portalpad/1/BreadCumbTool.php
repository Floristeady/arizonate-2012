<?

	class BreadCumbTool {
		function BreadCumbTool() {
			$this->section = null;
			$this->content = null;
			$this->section_id = null;
			$this->title = "Usted est� aqui";
			
			$this->separator = " > ";
			$this->linked = true;

		}
		function generate() {
			$this->elements = array();
			if (isset($this->section) && !isset($this->content)) {
				/*
					Se est� en una portada de secci�n
				*/
				$this->elements[] = $this->section;

			} 
			elseif (isset($this->section) && isset($this->content)) {
				/*
					Se est� en un contenido dentro de una secci�n. 
					Se revisan parents de contenidos a trav�s de cross_refferences que sean parents en 2 iveles hacia atr�s
				*/				
				$parent_content = $this->content->getParentContent();
				if ($parent_content)
					$parent_content2 = $parent_content->getParentContent();
				if ($parent_content2)
					$this->elements[] = $parent_content2;
				if ($parent_content)
					$this->elements[] = $parent_content;
				else
					$this->elements[] = $this->section;
				$this->elements[] = $this->content;

			}
			elseif (!isset($this->section) && isset($this->content)) {
				$this->elements[] = $this->content->getPrimarySection();
				$this->elements[] = $this->content;
			}
			elseif (!isset($this->section) && !isset($this->content)) {
			}
			if (isset($this->section)) {
				$this->temp_section = $this->section;

				while ($parent = $this->temp_section->getParent()) {
					array_unshift($this->elements, $this->temp_section->parent);
					$this->temp_section = $parent;
				}
			}	
			$this->elements_text = array();
			foreach ($this->elements as $key => $element) {
					$this->elements_text[$key] = $element->getPublicName();
			}

		}
		
		function output($shortened = false) {
			$this->generate();

			$elements = array();
			foreach ($this->elements as $key => $element) {
				if ($this->linked && $key != count($this->elements)-1)
					$elements[$key] = "<a href='".$element->getItemLink()."'>".$element->getPublicName()."</a>";
				else
					$elements[$key] = $element->getPublicName();
			}

			if (!$shortened) {
				echo $this->title.": ";
				echo implode($this->separator, $elements);	
			}
			else {
				echo implode($this->separator, array_slice($elements,1,count($elements)-2));	
			}
		}
		function fetch_element_text($index = 0) {
			return $this->elements_text[$index];
		}
		function fetch_element_reverted_text($index = 0) {
			$reversed_elements_text = array_reverse($this->elements_text);
			return $reversed_elements_text[$index];
		}
	}