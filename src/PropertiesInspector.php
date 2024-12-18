<?php

namespace Inspector;

use Inspector\Helpers\TypeChecker;
use Inspector\Helpers\ClassesInspectorHelper;

class PropertiesInspector implements InspectorInterface
{    	
	public function __construct() {	
	}

	/**
	* queries all classes for properties names matching the search query.
	*
	* @param string $searchTerm
	* 
	* @return bool
	*/	
	public function find(string $searchTerm): bool
	{
		$ci = new ClassesInspectorHelper();
		
		$tc = new TypeChecker($ci);
		
		$tc->isProperty($searchTerm);		
	}	

	/**
	* gets the properties data ready for the formatted string 
	*
	* @param string $searchTerm
	* 
	* @return null|array
	*/	
	public function getPrintingData(string $searchTerm): ?array
	{
		if ($this->find($searchTerm) === false) {			
			return null;	
		}	
		
		$formatted_str = strtolower(trim($searchTerm));
		
		$ci = new ClassesInspectorHelper();
		$cfqns = [];
		$cfqns = $ci->cfqns;
				
		$stackedDataArray = [];	
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();
						
		$props_arr = [];
		
		if (!empty($cfqns)) {
				
			foreach ($cfqns as $cfqn_key => $cfqn) {
				
				if (!empty($stackedDataArray[$cfqn_key]['properties'])) {
				
					foreach ($stackedDataArray[$cfqn_key]['properties'] as $property_name) {
					
						if (strcmp($formatted_str,strtolower($property_name)) == 0) {		
						
							$rp = new ReflectionProperty($cfqn,$property_name); 	
							$rc = new ReflectionClass($cfqn);
							
							$props_arr['name'] = $rp->getName();
							$props_arr['is_public'] = $rp->isPublic();
							$props_arr['is_protected'] = $rp->isProtected();
							$props_arr['is_private'] = $rp->isPrivate();
							$props_arr['is_readonly'] = $rp->isReadOnly();
							$props_arr['is_static'] = $rp->isStatic();
							$props_arr['type'] = (is_null($rp->getType())) ? 'no type' : $rp->getType()->getName();
							
							$props_arr['default_value'] = (is_null($rc->getProperty($property_name)->getDefaultValue())) ? 
							                               'null default value or unitialized typed property' : $rc->getProperty($property_name)->getDefaultValue();
							
							$att_arr = [];
							$att_arr = (!empty($rp->getAttributes())) ? $rp->getAttributes() : null; 
							
							$att_str = (!empty($att_arr)) ? implode(", ",$att_arr) : 'none';
							
							
							$props_arr['attributes'] = $att_str;
							
							$props_arr['class'] = $stackedDataArray[$cfqn_key]['name'];						
						        $props_arr['filename'] = $stackedDataArray[$cfqn_key]['filename'];
						}					
					}
				}
			}
		}
		
		return $props_arr;
	}

	/**
	* prints the properties data formatted string 
	*
	* @param string $searchTerm
	* 
	* @return null|string
	*/    
	public function printData(string $searchTerm): ?string
	{
		if (is_null($this->getPrintingData($searchTerm))) {
			
			return null;
		}	
	
		$props_arr = [];
		
		$props_arr = $this->getPrintingData($searchTerm);
	
		$formatted_str = '';
	
		foreach ($props_arr as $arr) {
			
			$is_public = ($arr['is_public'] === true) ? 'yes' : 'no';
			$is_protected = ($arr['is_protected'] === true) ? 'yes' : 'no';
			$is_private = ($arr['is_private'] === true) ? 'yes' : 'no';
			$is_readonly = ($arr['is_readonly'] === true) ? 'yes' : 'no';
			$is_static = ($arr['is_static'] === true) ? 'yes' : 'no';
						 
			$formatted_str .= sprintf(
				'\n
				Data type: Property\n
				Property name: %s\n
				Property class: %s\n
				Property data type: %s\n
				Property default value: %s\n
				Public: %s\n
				Protected: %s\n
				Private: %s\n
				Read-only: %s\n
				Static: %s\n
				Attributes: %s\n
				Filename: %s\n',
				$arr['name'],$arr['class'],$arr['type'],$arr['default_value'],$is_public,$is_protected,
				$is_private,$is_readonly,$is_static,$arr['attributes'],$arr['filename']
			);		 
		}
		
		return $formatted_str;		
	}
}
