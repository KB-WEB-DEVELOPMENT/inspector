<?php

namespace Inspector;

use Inspector\Helpers\TypeChecker;
use Inspector\Helpers\ClassesInspectorHelper;

class ParametersInspector implements InspectorInterface
{    	
	public function __construct() {	
	}

	/**
	* queries all classes for parameters names matching the search query.
	*
	* @param string $searchTerm
	* 
	* @return bool
	*/	
	public function find(string $searchTerm = " "): bool
	{
		$ci = new ClassesInspectorHelper();
		
		$tc = new TypeChecker($ci);
		
		$tc->isParameter($searchTerm);		
	}	

	/**
	* gets the parameters data ready for the formatted string 
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
						
		$params_arr = [];
		
		if (!empty($cfqns)) {
				
			foreach ($cfqns as $cfqn_key => $cfqn) {
				
				if (!empty($stackedDataArray[$cfqn_key]['parameters'])) {
				
					foreach ($stackedDataArray[$cfqn_key]['parameters'] as $param_name) {
					
						if (strcmp($formatted_str,strtolower($param_name)) == 0) {		
						
							$params_arr['param_name'] = $param_name;
							$params_arr['param_class_cfqn'] = $stackedDataArray[$cfqn_key]['name']; 
							$params_arr['param_namespace'] = $stackedDataArray[$cfqn_key]['namespace'] ?? 'not in a namespace';
							$params_arr['param_filename'] = $stackedDataArray[$cfqn_key]['filename'];
						}					
					}
				}
			}
		}
		
		return $params_arr;
	}

	/**
	* prints the parameters data formatted string 
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
	
		$params_arr = [];	
		
		$params_arr = $this->getPrintingData($searchTerm);
	
	    $formatted_str = '';
	
		foreach ($params_arr as $arr) {
			 
			$formatted_str .= sprintf(
				'\n
				Data type: Parameter\n
				Parameter name: %s\n
				Parameter class fully qualified name: %s\n
				Namespace: %s\n 
				File location: %s\n',			
				$arr['param_name'],$arr['param_class_cfqn'],$arr['param_namespace'],$arr['param_filename']);		 
		}
		
		return $formatted_str;		
	}
}
