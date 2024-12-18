<?php

namespace Inspector;

use Inspector\Helpers\ClassesInspectorHelper;
use Inspector\Helpers\TypeChecker;

class ExtensionsNamesInspector implements InspectorInterface
{    	
	public function __construct() {	
	}

	/**
	* queries all classes for extensions names matching the search query.
	*
	* @param string $searchTerm
	* 
	* @return bool
	*/	
	public function find(string $searchTerm): bool
	{
		$ci = new ClassesInspectorHelper();
		
		$tc = new TypeChecker($ci);
		
		$tc->isExtensionName($searchTerm);		
	}	

	/**
	* gets the extensions names data ready for the formatted string 
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
		
		$ext_names_arr = [];

		if (!empty($cfqns)) {
			
			foreach ($cfqns as $cfqn_key => $cfqn) {
				
				if  ( ($stackedDataArray[$cfqn_key]['reflection_extension_class_name'] != 'user defined class') &&
				      (strcmp($formatted_str,strtolower($stackedDataArray[$cfqn_key]['reflection_extension_class_name'])) == 0)     	
			        ) {		
						$ext_names_arr['name'] = $stackedDataArray[$cfqn_key]['reflection_extension_class_name'];
						$ext_names_arr['namespace'] = $stackedDataArray[$cfqn_key]['namespace'] ?? 'not in a namespace';
						$ext_names_arr['filename'] = $stackedDataArray[$cfqn_key]['filename'];
					}
			}
		}		
	
		return $ext_names_arr;
	
	}

	/**
	* prints extensions names data formatted string 
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
	
		$ext_names_arr = []; 
		
		$ext_names_arr = $this->getPrintingData($searchTerm);
	
		$formatted_str = '';
	
		foreach ($abstr_classes_arr as $arr) {
			 
			$formatted_str .= sprintf(
				'\n
				Data type: Reflection Extension Name\n
				Reflection extension name: %s\n
				Namespace: %s\n 
				File location: %s\n',			
				$arr['name'],$arr['namespace'],$arr['filename']);		 
		}
		
		return $formatted_str;
	}
}