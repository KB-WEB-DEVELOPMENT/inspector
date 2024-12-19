<?php

namespace Inspector;

use Inspector\Helpers\TypeChecker;
use Inspector\Helpers\ClassesInspectorHelper;

class TraitsInspector implements InspectorInterface
{    	
	public function __construct() {	
	}

	/**
	* queries all classes for traits names matching the search query.
	*
	* @param string $searchTerm
	* 
	* @return bool
	*/	
	public function find(string $searchTerm = " "): bool
	{
		$ci = new ClassesInspectorHelper();
		
		$tc = new TypeChecker($ci);
		
		$tc->isTrait($searchTerm);		
	}
	
	/**
	* gets the traits data ready for the formatted string 
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
						
		$traits_arr = [];

		if (!empty($cfqns)) {
		
			foreach ($cfqns as $cfqn_key => $cfqn) {

				if (!empty($stackedDataArray[$cfqn_key]['traits'])) {
			
					foreach ($stackedDataArray[$cfqn_key]['traits'] as $key => $trait_name) {
			
						if  (strcmp($formatted_str,strtolower($trait_name)) == 0) {		
					       
							$traits_arr['name'] = $trait_name;
							$traits_arr['filename'] = $stackedDataArray[$cfqn_key]['filename'];
						}
					}
				}
			}
		}
	
		return $traits_arr;		
	}

	/**
	* prints the traits data formatted string 
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
	
		$traits_arr = [];
		
		$traits_arr = $this->getPrintingData($searchTerm);
		
	        $formatted_str = '';		
	
		foreach ($traits_arr as $arr) {
			 
			$formatted_str .= sprintf(
				'\n
				Data type: Trait\n
				Trait name: %s\n
				File location: %s\n', 			
				$arr['name'],$arr['filename']);		 
		}
		
		return $formatted_str;		
	}
}
