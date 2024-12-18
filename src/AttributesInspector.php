<?php

namespace Inspector;

use Inspector\Helpers\ClassesInspectorHelper;
use Inspector\Helpers\TypeChecker;

class AttributesInspector implements InspectorInterface
{    		
	public function __construct() {	
	}

	/**
	* queries all classes for attributes names matching the search query.
	*
	* @param string $searchTerm
	* 
	* @return bool
	*/	
	public function find(string $searchTerm): bool
	{
		$ci = new ClassesInspectorHelper();
		
		$tc = new TypeChecker($ci);
		
		$tc->isAttribute($searchTerm);
		
	}	

	/**
	* gets the attributes data ready for the formatted string 
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
		
		$attributes_arr = [];
		
		if (!empty($cfqns)) {
				
			foreach ($cfqns as $cfqn_key => $cfqn) {
				
				if (!empty($stackedDataArray[$cfqn_key]['attributes'])) {
			
					foreach ($stackedDataArray[$cfqn_key]['attributes'] as $att_name) {
			
						if  (strcmp($formatted_str,strtolower($att_name)) == 0) {	
						
						    $attributes_arr['name'] = $att_name;
							$attributes_arr['namespace'] = $stackedDataArray[$cfqn_key]['namespace'] ?? 'not in a namespace';
							$attributes_arr['filename'] = $stackedDataArray[$cfqn_key]['filename'];
						}
					}
				}	
			}
		}
				
		return $attributes_arr;		
	}

	/**
	* prints the attributes data formatted string 
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
	
		$attributes_arr = [];
		
		$attributes_arr = $this->getPrintingData($searchTerm);
		
		$formatted_str = '';
		
		foreach ($attributes_arr as $arr) {
			 
			$formatted_str .= sprintf(
				'\n
				Data type: Attribute\n
				Attribute name: %s\n 
				Namespace: %s\n
				Filename: %s\n',			
				$arr['name'],$arr['namespace'],$arr['filename']);		
		}
			
		return $formatted_str; 		
	}
}