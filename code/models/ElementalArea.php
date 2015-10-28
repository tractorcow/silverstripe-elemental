<?php

/**
 * @package elemental
 */
class ElementalArea extends WidgetArea {

	public function Elements() {
		$result = $this->getComponents('Widgets');

		$list = new HasManyList('BaseElement', $result->getForeignKey());
		$list->setDataModel($this->model);
		$list = $list->filter('Enabled', 1);
		$list = $list->sort('Sort ASC');
		
		$list = $list->forForeignID($this->ID);

		return $list;
	}

	/**
	* Return an ArrayList of pages with the Element Page Extension
	*
	* @return ArrayList
	*/
	public function getOwnerPage() {

	    foreach (get_declared_classes() as $class) {
	        if (is_subclass_of($class, 'SiteTree')) {
	        	$object = singleton($class);
	        	if ($object->hasExtension('ElementPageExtension')) {
	        		$page = $class::get()->filter('ElementAreaID', $this->ID);
	        		if ($page->exists()) {
	        			return $page->First();
	        		}
	        	}
	        }
	    }

	    return false;
	}


}