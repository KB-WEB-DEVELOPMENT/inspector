<?php

namespace Inspector;

use Inspector\Helpers\ClassesInspectorHelper;
use Inspector\Helpers\TypeChecker;
use Inspector\Helpers\ArraysHelper;

class ArrayStringValuesInspector implements InspectorInterface
{    		
	public function __construct() {	
	}
	
	/**
	* queries all config arrays values for names matching the search query.
	*
	* @param string $searchTerm
	* 
	* @return bool
	*/		
	public function find(string $searchTerm): bool
	{
		$ci = new ClassesInspectorHelper();
		
		$tc = new TypeChecker($ci);
		
		$tc->isArrayStringValue($searchTerm);		
	}	

	/**
	* gets the config arrays values data ready for the formatted string 
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

		$valuesArray = [];
		
		$arraysInDirsData = [];
				
		$arraysInDirsData = ArraysHelper::getArraysData();
		
		$found_values_arr = [];
				
		if (!empty($arraysInDirsData)) {
			
			foreach ($arraysInDirsData as $arrayFiles) {
				
				foreach ($arrayFiles['array_content'] as $file_key => $arr) {
				
					$valuesArray = array_values(array_change_key_case($arr,CASE_LOWER));
					
					if (in_array($formatted_str,$valuesArray)  && (empty(array_filter($valuesArray,'checkValuesStrings'))) ) {
						
						$found_values_arr['search_term'] = $searchTerm;
						$found_values_arr['array_filepath'] = $arrayFiles['array_filepath'][$file_key];
						
					}
					
					unset($valuesArray);	
				}
			}		
		}
		
		return $found_values_arr;				
	}

	/**
	* checks that only arrays values which are string are queried 
	*
	* @param mixed $val
	* 
	* @return bool
	*/	
	protected function checkValuesStrings(mixed $val): bool
	{
		return (gettype($var) != 'string');
	}

	/**
	* prints the config arrays values data formatted string 
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
	
		$found_values_arr = [];
		
		$found_values_arr = $this->getPrintingData($searchTerm);		
		
		$formatted_str = '';
	
		foreach ($found_values_arr as $arr) {
			 
			$formatted_str .= sprintf(
				'\n
				Data type: Array string value\n
				Array value for key: %s\n
				File location: %s\n',			
				$arr['search_term'],$arr['array_filepath']);		 
		}
		
		return $formatted_str;
		
	}
}