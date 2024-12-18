<?php

namespace Inspector;

use Inspector\Helpers\TypeChecker;
use Inspector\Helpers\ClassesInspectorHelper;

class TraitsAliasesInspector implements InspectorInterface
{    	
	public function __construct() {	
	}

	/**
	* queries all classes for traits aliases names matching the search query.
	*
	* @param string $searchTerm
	* 
	* @return bool
	*/	
	public function find(string $searchTerm): bool
	{
		$ci = new ClassesInspectorHelper();
		
		$tc = new TypeChecker($ci);
		
		$tc->isTraitAlias($searchTerm);		
	}	

	/**
	* gets the traits aliases data ready for the formatted string 
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
						
		$traits_aliases_arr = [];

		if (!empty($cfqns)) {
		
			foreach ($cfqns as $cfqn_key => $cfqn) {

				if (!empty($stackedDataArray[$cfqn_key]['traits_aliases_names'])) {
			
					foreach ($stackedDataArray[$cfqn_key]['traits_aliases_names'] as $key => $trait_alias_name) {
			
						if  (strcmp($formatted_str,strtolower($trait_alias_name)) == 0) {		
					       
							$traits_aliases_arr['name'] = $trait_alias_name;
							$traits_aliases_arr['filename'] = $stackedDataArray[$cfqn_key]['filename'];
						}
					}
				}
			}
		}

		return $traits_aliases_arr;		
	}

	/**
	* prints the traits aliases data formatted string 
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
	
		$traits_aliases_arr = [];
		
		$traits_aliases_arr = $this->getPrintingData($searchTerm);
	
	        $formatted_str = '';
	
		foreach ($traits_aliases_arr as $arr) {
			 
			$formatted_str .= sprintf(
				'\n
				Data type: Trait Alias\n
				Trait alias name: %s\n
				File location: %s\n', 			
				$arr['name'],$arr['filename']);		 
		}
		
		return $formatted_str; 		
	}
}
