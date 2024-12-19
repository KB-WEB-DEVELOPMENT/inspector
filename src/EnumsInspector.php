<?php

namespace Inspector;

use Inspector\Helpers\ClassesInspectorHelper;
use Inspector\Helpers\TypeChecker;

class EnumsInspector implements InspectorInterface
{    	
	public function __construct() {	
	}

	/**
	* queries all classes for enums matching the search query.
	*
	* @param string $searchTerm
	* 
	* @return bool
	*/	
	public function find(string $searchTerm = " "): bool
	{
		$ci = new ClassesInspectorHelper();
		
		$tc = new TypeChecker($ci);
		
		$tc->isEnum($searchTerm);
	}	

	/**
	* gets the enums data ready for the formatted string 
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
						
		$enums_arr = [];
		
		if (!empty($cfqns)) {
			
			foreach ($cfqns as $cfqn_key => $cfqn) {
			
				if  ( ($stackedDataArray[$cfqn_key]['is_enum'] === true) &&
				      (strcmp($formatted_str,strtolower($stackedDataArray[$cfqn_key]['short_name'])) == 0)     	
			        ) {		
				  	    $enums_arr['short_name'] = $stackedDataArray[$cfqn_key]['short_name'];
						$enums_arr['name'] = $stackedDataArray[$cfqn_key]['name'];
						$enums_arr['namespace'] = $stackedDataArray[$cfqn_key]['namespace'] ?? 'not in a namespace';
						$enums_arr['filename'] = $stackedDataArray[$cfqn_key]['filename'];
						$enums_arr['start_line'] = $stackedDataArray[$cfqn_key]['start_line'];
						$enums_arr['end_line'] = $stackedDataArray[$cfqn_key]['end_line'];
				}
			}
		}
				
		return $enums_arr;

	}

	/**
	* prints the enums data formatted string 
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
	
		$enums_arr = [];
		
		$enums_arr = $this->getPrintingData($searchTerm);
	
	    $formatted_str = '';

		foreach ($enums_arr as $arr) {
			 
			$formatted_str .= sprintf(
				'\n
				Data type: Enum\n
				Enum short name: %s\n
				Fully qualified enum name: %s\n
				Namespace: %s\n				
				File location: %s\n
				Start line: %u\n
				End line: %u\n',			
				$arr['short_name'],$arr['name'],$arr['namespace'],$arr['filename'],$arr['start_line'],$arr['end_line']);		 
		}
		
		return $formatted_str;
		
	}
}
