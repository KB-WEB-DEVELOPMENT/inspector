<?php

namespace Inspector;

use Inspector\Helpers\ClassesInspectorHelper;
use Inspector\Helpers\TypeChecker;

class MethodsInspector implements InspectorInterface
{    	
	public function __construct() {	
	}

	/**
	* queries all classes for methods names matching the search query.
	*
	* @param string $searchTerm
	* 
	* @return bool
	*/	
	public function find(string $searchTerm): bool
	{
		$ci = new ClassesInspectorHelper();
		
		$tc = new TypeChecker($ci);
		
		$tc->isMethod($searchTerm);		
	}	

	/**
	* gets the methods data ready for the formatted string 
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

		$methods_arr = [];
		
		if (!empty($cfqns)) {
				
			foreach ($cfqns as $cfqn_key => $cfqn) {
				
				if (!empty($stackedDataArray[$cfqn_key]['methods'])) {
			
					foreach ($stackedDataArray[$cfqn_key]['methods'] as $method_name) {
			
						if  (strcmp($formatted_str,strtolower($method_name)) == 0) {		
					       						
						     //https://www.php.net/manual/en/reflectionmethod.construct.php
							
						    $rm = new ReflectionMethod(stackedDataArray[$cfqn_key]['cfqn'],$method_name);
														
						    $methods_arr['name'] = $method_name;							
						    $methods_arr['is_internal'] = $rm->isInternal();
						    $methods_arr['is_abstract'] = $rm->isAbstract();
						    $methods_arr['is_final'] = $rm->isFinal();
						    $methods_arr['is_public'] = $rm->isPublic();
						    $methods_arr['is_private'] = $rm->isPrivate();
						    $methods_arr['is_protected'] = $rm->isProtected();
						    $methods_arr['is_static'] = $rm->isStatic();
						    $methods_arr['is_constructor'] = $rm->isConstructor();
						    $methods_arr['class'] = $stackedDataArray[$cfqn_key]['name'];
						    $methods_arr['filename'] = $stackedDataArray[$cfqn_key]['filename'];
   						
						}
					}
				}
			}

		}
		
		return $methods_arr;	
	}

	/**
	* prints the methods data formatted string 
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
	
		$methods_arr = [];
		
		$methods_arr = $this->getPrintingData($searchTerm);
	
		$formatted_str = '';
		
		foreach ($methods_arr as $arr) {
			
			$is_internal = ($arr['is_internal'] === true) ? 'yes' : 'no';
			$is_abstract = ($arr['is_abstract'] === true) ? 'yes' : 'no';			 
			$is_final = ($arr['is_final'] === true) ? 'yes' : 'no';
			$is_public = ($arr['is_public'] === true) ? 'yes' : 'no';
			$is_private = ($arr['is_private'] === true) ? 'yes' : 'no';
			$is_protected = ($arr['is_protected'] === true) ? 'yes' : 'no';				
			$is_static = ($arr['is_static'] === true) ? 'yes' : 'no';
			$is_constructor = ($arr['is_constructor'] === true) ? 'yes' : 'no';	
						 
			$formatted_str .= sprintf(
				'\n
				Data type: Method\n
				Method name: %s\n
				Method Class: %s\n
				Internal: %s\n 
				Abstract: %s\n
				Final: %s\n
				Public: %s\n
				Private: %s\n
				Protected: %s\n
				Static: %s\n				
				Constructor: %s\n
                                File location: %s\n',			
				$arr['name'],$arr['class'],$is_internal,$is_abstract,$is_final,$is_public,$is_private,
				$is_protected,$is_static,$is_constructor,$arr['filename']);		 
		}
		
		return $formatted_str;				
	}
}
