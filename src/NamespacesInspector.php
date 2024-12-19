<?php

namespace Inspector;

use Inspector\Helpers\TypeChecker;
use Inspector\Helpers\ClassesInspectorHelper;

class NamespacesInspector implements InspectorInterface
{    	
	public function __construct() {	
	}

	/**
	* queries all classes for namespaces names matching the search query.
	*
	* @param string $searchTerm
	* 
	* @return bool
	*/	
	public function find(string $searchTerm = " "): bool
	{
		$ci = new ClassesInspectorHelper();
		
		$tc = new TypeChecker($ci);
		
		$tc->isNamespace($searchTerm);		
	}	

	/**
	* gets the namespaces data ready for the formatted string 
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
						
		$namespaces_arr = [];

		if (!empty($cfqns)) {
		
			foreach ($cfqns as $cfqn_key => $cfqn) {
			
				if (!empty($stackedDataArray[$cfqn_key]['namespace'])) {
				
					foreach ($stackedDataArray[$cfqn_key]['namespace'] as $key => $namespace) {
					
						if (strcmp($formatted_str,strtolower($namespace)) == 0) {		
						
							$namespaces_arr['name'] = $namespace;
							$namespaces_arr['filename'] = $stackedDataArray[$cfqn_key]['filename'];
						}					
					}
				}
			}
		}
		
		return $namespaces_arr;
	}

	/**
	* prints the namespaces data formatted string 
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
	
		$namespaces_arr = [];
		
		$namespaces_arr = $this->getPrintingData($searchTerm);
	
		$formatted_str = '';
	
		foreach ($namespaces_arr as $arr) {
			 
			$formatted_str .= sprintf(
				'\n
				Data type: Namespace\n
				Name: %s\n
				Filename: $s\n',
				$arr['name'],$arr['filename']);		 
		}
		
		return $formatted_str; 				
	}
}
