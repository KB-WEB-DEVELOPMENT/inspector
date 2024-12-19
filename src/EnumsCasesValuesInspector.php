<?php

namespace Inspector;

use Inspector\Helpers\ClassesInspectorHelper;
use Inspector\Helpers\TypeChecker;

class EnumsCasesValuesInspector implements InspectorInterface
{    	
	public function __construct() {	
	}

	/**
	* queries all classes for enums cases (string) values matching the search query.
	*
	* @param string $searchTerm
	* 
	* @return bool
	*/
	public function find(string $searchTerm = " "): bool
	{
		$ci = new ClassesInspectorHelper();
		
		$tc = new TypeChecker($ci);
		
		$tc->isEnumCaseValue($searchTerm);		
	}	

	/**
	* gets the enums cases (string) values data ready for the formatted string 
	*
	* @param string $searchTerm
	* 
	* @return null|array
	*/	
	public function getPrintingData(string $searchTerm = " "): ?array
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

		$enums_cases_val_arr = [];
		
		if (!empty($cfqns)) {
				
			foreach ($cfqns as $cfqn_key => $cfqn) {
				
				if (!empty($stackedDataArray[$cfqn_key]['enums_cases_values'])) {
			
					foreach ($stackedDataArray[$cfqn_key]['enums_cases_values'] as $enum_case_value) {
			
						if  (strcmp($formatted_str,strtolower($enum_case_value)) == 0) {		
							
							$enums_cases_val_arr['name'] = $enum_case_value;
							$enums_cases_val_arr['namespace'] = $stackedDataArray[$cfqn_key]['namespace'] ?? 'not in a namespace';
							$enums_cases_val_arr['filename'] = $stackedDataArray[$cfqn_key]['filename'];
						}
					}
				}				
			}
		}
		return $enums_cases_val_arr;
	}

	/**
	* prints the enums cases (string) values data formatted string 
	*
	* @param string $searchTerm
	* 
	* @return null|string
	*/	  
	public function printData(string $searchTerm = " "): ?string
	{
		if (is_null($this->getPrintingData($searchTerm))) {
			
			return null;
		}	
	
		$enums_cases_val_arr = [];
		
		$enums_cases_val_arr = $this->getPrintingData($searchTerm);
	
		$formatted_str = '';
	
		foreach ($enums_cases_val_arr as $arr) {
			 
			$formatted_str .= sprintf(
				'\n
				Data type: Enum case value\n
				Enum case value name: %s\n
				Namespace: %s\n 
				File location: %s\n',			
				$arr['name'],$arr['namespace'],$arr['filename']);		 
		}
		
		return $formatted_str;
	}
}
