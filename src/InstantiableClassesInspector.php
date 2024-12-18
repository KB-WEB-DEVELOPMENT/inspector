<?php

namespace Inspector;

use Inspector\Helpers\ClassesInspectorHelper;
use Inspector\Helpers\TypeChecker;

class InstantiableClassesInspector implements InspectorInterface
{    	
	public function __construct() {	
	}

	/**
	* queries all classes for instantiable classes names matching the search query.
	*
	* @param string $searchTerm
	* 
	* @return bool
	*/	
	public function find(string $searchTerm): bool
	{
		$ci = new ClassesInspectorHelper();
		
		$tc = new TypeChecker($ci);
		
		$tc->isInstantiableClass($searchTerm);
	}	

	/**
	* gets the instantiable classes data ready for the formatted string 
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
		
		$inst_classes_arr = [];
		
		if (!empty($cfqns)) {
				
			foreach ($cfqns as $cfqn_key => $cfqn) {
				
				if  ( ($stackedDataArray[$cfqn_key]['is_instantiable'] === true) &&
					  (strcmp($formatted_str,strtolower($stackedDataArray[$cfqn_key]['short_name'])) == 0)     	
					){													  						
						$inst_classes_arr['short_name'] = $stackedDataArray[$cfqn_key]['short_name'];
						$inst_classes_arr['name'] = $stackedDataArray[$cfqn_key]['name'];
						$inst_classes_arr['is_final'] = $stackedDataArray[$cfqn_key]['is_final'];
						$inst_classes_arr['is_readonly'] = $stackedDataArray[$cfqn_key]['is_readonly'];
						$inst_classes_arr['is_cloneable'] = $stackedDataArray[$cfqn_key]['is_cloneable'];
						$inst_classes_arr['filename'] = $stackedDataArray[$cfqn_key]['filename'];
						$inst_classes_arr['namespace'] = $stackedDataArray[$cfqn_key]['namespace'] ?? 'not in a namespace';
						$inst_classes_arr['start_line'] = $stackedDataArray[$cfqn_key]['start_line'];
						$inst_classes_arr['end_line'] = $stackedDataArray[$cfqn_key]['end_line'];
						
						$cl = new ReflectionClass($cfqn);
						
						$att_arr = [];
						$att_arr = $cl->getAttributes();
						
						$att_names_arr = [];
						if (!empty($att_arr)) {
							$att_names_arr = array_map(fn($attribute) => $attribute->getName(), $att_arr); 	
						}	
						
						$att_str =  (!empty($att_names_arr)) ? implode(", ",$att_names_arr) : 'no attributes'; 
												
						$inst_classes_arr['attributes'] = $att_str;
						
						$constants_arr = [];
						$constants_arr = $cl->getConstants();
						
						$constants_names_arr = [];
						if (!empty($constants_arr)) {
							$constants_names_arr = array_keys($constants_arr);	
						}
						
						$constants_str = (!empty($constants_names_arr)) ? implode(", ",$constants_names_arr) : 'no constants';
						
						
						$inst_classes_arr['constants'] = $constants_str;
						
						$methods_arr = [];
						$methods_arr = $cl->getMethods();
						
						$methods_names_arr = [];
						if (!empty($methods_arr)) {
							
							foreach ($methods_arr as $key => $value) { 
								$methods_names_arr[] = 	$value['name'];
							}
						}

						$methods_str = (!empty($methods_names_arr)) ? implode(", ",$methods_names_arr) : 'no methods';		
						
						$inst_classes_arr['methods'] = $methods_str;
						
						$props_arr = [];
						$props_arr = $cl->getProperties();
						
						$props_names_arr = [];
						if (!empty($props_arr)) {
							$props_names_arr = array_map(fn($property) => $property->getName(), $props_arr); 	
						}	
						
						$props_str =  (!empty($props_names_arr)) ? implode(", ",$props_names_arr) : 'no properties'; 
												
						$inst_classes_arr['properties'] = $props_str;
						
						$traits_arr = [];
						$traits_arr = $cl->getTraitNames();
						
						$traits_str =  (!empty($traits_arr)) ? implode(", ",$traits_arr) : 'no traits';
											
						$inst_classes_arr['traits'] = $traits_str;					
					}
			}
		}
		return $inst_classes_arr;
	}

	/**
	* prints the instantiable classes data formatted string 
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
	
		$inst_classes_arr = [];
		
		$inst_classes_arr = $this->getPrintingData($searchTerm);
	
	    $formatted_str = '';
	
		foreach ($inst_classes_arr as $arr) {
			
			$is_final =  ($arr['is_final'] === true) ? 'yes' : 'no'; 
			$is_readonly = ($arr['is_readonly'] === true) ? 'yes' : 'no';
			$is_cloneable = ($arr['is_cloneable'] === true) ? 'yes' : 'no';
			 			
			$formatted_str .= sprintf(
				'\n
				Data type: Instantiable class\n
				Class short name: %s\n
				Fully qualified class name: %s\n 
				Final: %s\n
				Read-only: %s\n
				Cloneable: %s\n
				Namespace: %s\n
				Filename: %s\n
				Start line: %u\n
				End line: %u\n
				Attributes: %s\n
				Constants: %s\n
				Methods: %s\n
				Properties: %s\n				
				Traits: %s\n',							
				$arr['short_name'],$arr['name'],$is_final,$is_readonly,$is_cloneable,$arr['namespace'],
				$arr['filename'],$arr['start_line'],$arr['end_line'],$arr['attributes'],$arr['constants'],$arr['methods'],
				$arr['properties'],$arr['traits']);
		}
		
		return $formatted_str; 
	}
}