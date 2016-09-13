<?
	abstract class MenuItem extends Translatable{
		
		function MenuItem() {
				$this->parent_section = null;
		}
		function expands() {
				if (get_class($this) == "Section") {
					if ($this->menu_expand_children && $this->hasChildren()) {
						return true;
					}
					if ($this->menu_expand_contents&& $this->hasContents()) {
						return true;
					}
				}
				if (get_class($this) == "Content") {
					$parent_section = $this->getPrimarySection();
					if ($parent_section->menu_expand_related && $this->hasRelated($parent_section->menu_expand_related_type)) {
						return true;
					}
				}
				return false;
		}
	}