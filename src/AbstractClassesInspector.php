<?php

namespace Inspector;

use Inspector\Helpers\TypeChecker;
use Inspector\Helpers\ClassesInspectorHelper;

class AbstractClassesInspector implements InspectorInterface
{ 	
	public function __construct() {	
	}
	
	/**
	* queries all classes for abstract classes names matching the search query.
	*
	* @param string $searchTerm
	* 
	* @return bool
	*/
	public function find(string $searchTerm): bool
	{
		$ci = new ClassesInspectorHelper();
		
		$tc = new TypeChecker($ci);
		
		$tc->isAbstractClass($searchTerm);
	}	

	/**
	* gets the abstract classes data ready for the formatted string 
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
						
		$abstr_classes_arr = [];
		
		if (!empty($cfqns)) {
				
			foreach ($cfqns as $cfqn_key => $cfqn) {
				
				if  ( ($stackedDataArray[$cfqn_key]['is_abstract'] === true) &&
					  (strcmp($formatted_str,strtolower($stackedDataArray[$cfqn_key]['short_name'])) == 0)     	
					){		
						$abstr_classes_arr['short_name'] = $stackedDataArray[$cfqn_key]['short_name'];
						$abstr_classes_arr['name'] = $stackedDataArray[$cfqn_key]['name'];
						$abstr_classes_arr['filename'] = $stackedDataArray[$cfqn_key]['filename'];
						$abstr_classes_arr['namespace'] = $stackedDataArray[$cfqn_key]['namespace'] ?? 'not in a namespace';
						$abstr_classes_arr['start_line'] = $stackedDataArray[$cfqn_key]['start_line'];
						$abstr_classes_arr['end_line'] = $stackedDataArray[$cfqn_key]['end_line'];
					}
			}

		}
		
		return $abstr_classes_arr;
	}

	/**
	* prints the abstract classes data formatted string 
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
	
		$abstr_classes_arr = [];
		
		$abstr_classes_arr = $this->getPrintingData($searchTerm);
		
		$formatted_str = '';
	
		foreach ($abstr_classes_arr as $arr) {
			 
			$formatted_str .= sprintf(
				'\n
				Data type: Abstract class\n
				Class short name: %s\n
				Fully qualified class name: %s\n 
				Namespace: %s\n
				File location: %s\n
				Start line: %u\n
				End line: %u\n',			
				$arr['short_name'],$arr['name'],$arr['namespace'],$arr['filename'],$arr['start_line'],$arr['end_line']);		 
		}
		
		return $formatted_str;
	}
}	