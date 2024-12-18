<?php

namespace Inspector;

use Inspector\Helpers\ClassesInspectorHelper;
use Inspector\Helpers\TypeChecker;

class ConstantsInspector implements InspectorInterface
{    	
	public function __construct() {	
	}
	
	/**
	* queries all classes for constants names matching the search query.
	*
	* @param string $searchTerm
	* 
	* @return bool
	*/	
	public function find(string $searchTerm): bool
	{
		$ci = new ClassesInspectorHelper();
		
		$tc = new TypeChecker($ci);
		
		$tc->isConstant($searchTerm);
	}	

	/**
	* gets the constants data ready for the formatted string 
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
						
		$constants_arr = [];
		
		if (!empty($cfqns)) {
				
			foreach ($cfqns as $cfqn_key => $cfqn) {
				
				if (!empty($stackedDataArray[$cfqn_key]['constants'])) {
			
					foreach ($stackedDataArray[$cfqn_key]['constants'] as $constant_name) {
			
						if  (strcmp($formatted_str,strtolower($constant_name)) == 0) {	
						
						    $constants_arr['name'] = $constant_name;
							$constants_arr['namespace'] = $stackedDataArray[$cfqn_key]['namespace'] ?? 'not in a namespace';
							$constants_arr['filename'] = $stackedDataArray[$cfqn_key]['filename'];
						}
					}
				}	
			}
		}
				
		return $constants_arr;		
	}

	/**
	* prints the constants data formatted string 
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
	
		$constants_arr = [];
		
		$constants_arr = $this->getPrintingData($searchTerm);
	
		$formatted_str = '';
	
		foreach ($constants_arr as $arr) {
			 
			$formatted_str .= sprintf(
				'\n
				Data type: Constant\n
				Constant name: %s\n
				Namespace: %s\n 
				File location: %s\n',		
				$arr['name'],$arr['namespace'],$arr['filename']);		 
		}
		
		return $formatted_str;
	}
	
}