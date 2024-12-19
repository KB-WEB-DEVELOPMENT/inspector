<?php

namespace Inspector;

use Inspector\Helpers\ClassesInspectorHelper;
use Inspector\Helpers\TypeChecker;

class EnumsCasesStringBackingValuesInspector implements InspectorInterface
{    	
	public function __construct() {	
	}

	/**
	* queries all classes for enums cases string backing values matching the search query.
	*
	* @param string $searchTerm
	* 
	* @return bool
	*/	
	public function find(string $searchTerm = " "): bool
	{
		$ci = new ClassesInspectorHelper();
		
		$tc = new TypeChecker($ci);
		
		$tc->isEnumCaseStringBackingValue($searchTerm);		
	}	

	/**
	* gets the enums cases string backing values data ready for the formatted string 
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
						
		$enums_cases_string_bv_arr = [];

		if (!empty($cfqns)) {
				
			foreach ($cfqns as $cfqn_key => $cfqn) {
				
				if (!empty($stackedDataArray[$cfqn_key]['enums_cases_backing_values'])) {
			
					foreach ($stackedDataArray[$cfqn_key]['enums_cases_backing_values'] as $key => $enum_case_value) {
			
						if  ( (strcmp(gettype($enum_case_value),'string') == 0)  && (strcmp($formatted_str,strtolower($enum_case_value)) == 0) ) {		
							
							$enums_cases_string_bv_arr['name'] =  $enum_case_value;
							$enums_cases_string_bv_arr['namespace'] = $stackedDataArray[$cfqn_key]['namespace'] ?? 'not in a namespace';							
							$enums_cases_string_bv_arr['filename'] = $stackedDataArray[$cfqn_key]['filename'];				
						}
					}
				}
			}
		}

		return $enums_cases_string_bv_arr;
	}

	/**
	* prints the enums cases string backing values data formatted string 
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
	
		$enums_cases_string_bv_arr = [];
		
		$enums_cases_string_bv_arr = $this->getPrintingData($searchTerm);
		
		$formatted_str = '';		

		foreach ($enums_cases_string_bv_arr as $arr) {
			 
			$formatted_str .= sprintf(
				'\n
				Data type: Enum string case backing value\n
				Enum string case backing value: %s\n
				Namespace: %s\n 
				Filename: %s\n',			
				$arr['name'],$arr['namespace'],$arr['filename']);		 
		}
		
		return $formatted_str;	
	}
}
