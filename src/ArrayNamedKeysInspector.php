<?php

namespace Inspector;

use Inspector\Helpers\ClassesInspectorHelper;
use Inspector\Helpers\TypeChecker;
use Inspector\Helpers\ArraysHelper;

class ArrayNamedKeysInspector implements InspectorInterface
{    		
	public function __construct() {	
	}
	
	/**
	* queries all config arrays keys for names matching the search query.
	*
	* @param string $searchTerm
	* 
	* @return bool
	*/		
	public function find(string $searchTerm): bool
	{
		$ci = new ClassesInspectorHelper();
		
		$tc = new TypeChecker($ci);
		
		$tc->isArrayNamedKey($searchTerm);
	}	
	
	/**
	* gets the config arrays keys data ready for the formatted string 
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

		$keysArray = [];
		
		$arraysInDirsData = [];
				
		$arraysInDirsData = ArraysHelper::getArraysData();
		
		$found_named_keys_arr = [];
				
		if (!empty($arraysInDirsData)) {
			
			foreach ($arraysInDirsData as $dir_key => $arrayFiles) {
				
				foreach ($arrayFiles['array_content'] as $file_key => $arr) {
				
					$keysArray = array_keys(array_change_key_case($arr,CASE_LOWER));
					
					if ( (in_array($formatted_str,$keysArray)) && (empty(array_filter($keysArray,'checkKeysStrings'))) ) {
						
						$found_named_keys_arr['search_term'] = $searchTerm;
						$found_named_keys_arr['array_filepath'] = $arrayFiles['array_filepath'][$file_key];
						
					}
					unset($keysArray);
				}
			}
		}

		return $found_named_keys_arr;		
	}
	
	/**
	* checks that only named arrays keys which are string are queried 
	*
	* @param mixed $val
	* 
	* @return bool
	*/	
	protected function checkKeysStrings(mixed $val): bool
	{
		return (gettype($var) != 'string');
	}

	/**
	* prints the config arrays keys data formatted string 
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
	
		$found_named_keys_arr = [];
		
		$found_named_keys_arr = $this->getPrintingData($searchTerm);
	
		$formatted_str = '';
	
		foreach ($found_named_keys_arr as $arr) {
			 
			$formatted_str .= sprintf(
				'\n
				Data type: Array named key\n
				Array key name: %s\n
				File location: %s\n',			
				$arr['search_term'],$arr['array_filepath']);		 
		}
		
		return $formatted_str;
	}
}