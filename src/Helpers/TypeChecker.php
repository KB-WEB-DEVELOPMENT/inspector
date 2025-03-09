<?php

namespace Inspector\Helpers;

class TypeChecker
{    	
      public function __construct(
	
      /**
      * The Classes Inspector Helper
      *
      * @var ClassesInspector
      */
      protected ClassesInspectorHelper $classesInspectorHelper
     ) {}
	
     /**
     * checks if the search query matches any abstract class name.
     *
     * @param string $searchTerm
     *
     * @return bool
     *
     */	
     protected function isAbstractClass(string $searchTerm = " "): bool
     {		
	   $formatted_str = strtolower(trim($searchTerm));
		
	    $cfqns = [];
	    $stackedDataArray = [];
		
	    $cfqns = ($this->classesInspectorHelper)->cfqns;
	    $stackedDataArray =  ClassesInspectorHelper::getArrayData();
		
	    $res = false;

	     if (!empty($cfqns)) {
			
		 foreach ($cfqns as $cfqn_key => $cfqn) {
			
		      if  ( ($stackedDataArray[$cfqn_key]['is_abstract'] === true) &&
			    (strcmp($formatted_str,strtolower($stackedDataArray[$cfqn_key]['short_name'])) == 0)     	
		          ){		
			      $res = true;
						
			      break;
			   }
		 }		
	     } 
	     return $res;
	}

	/**
	* checks if the search query matches any (string) associative array key name
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/
	
	protected function isArrayNamedKey(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$keysArray = [];
		
		$arraysInDirsData = [];
				
		$arraysInDirsData = ArraysHelper::getArraysData();
		
		$res = false;
		
		if (!empty($arraysInDirsData)) {
			
			foreach ($arraysInDirsData as $dir_key => $arrayFiles) {
				
				foreach ($arrayFiles['array_content'] as $file_key => $arr) {
				
					$keysArray = array_keys(array_change_key_case($arr,CASE_LOWER));
					
					if ( (in_array($formatted_str,$keysArray)) && (empty(array_filter($keysArray,'checkKeysStrings'))) ) {
						
						$res = true;
						
						break;
					}
					unset($keysArray);
				}
			}
		}
		return $res;			
	}

	/**
	* checks that all associative arrays keys are strings
	*
	* @param mixed $val
	*
	* @return bool
	*
	*/	
	protected function checkKeysStrings(mixed $val): bool
	{
		return (gettype($val) != 'string');
	}

	/**
	* checks if the search query matches any (string) associative array value name
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/
		
	protected function isArrayStringValue(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$valuesArray = [];
		
		$arraysInDirsData = [];
				
		$arraysInDirsData = ArraysHelper::getArraysData();
		
		$res = false;
		
		if (!empty($arraysInDirsData)) {
			
			foreach ($arraysInDirsData as $arrayFiles) {
				
				foreach ($arrayFiles['array_content'] as $file_key => $arr) {
				
					$valuesArray = array_values(array_change_key_case($arr,CASE_LOWER));
					
					if ( (in_array($formatted_str,$valuesArray))  && (empty(array_filter($keysArray,'checkValuesStrings'))) ) {
						
						$res = true;
						
						break;
					}
					
					unset($valuesArray);	
				}
			}		
		}
		return $res;		
	}

	/**
	* checks that all associative arrays values are strings
	*
	* @param mixed $val
	*
	* @return bool
	*
	*/
	protected function checkValuesStrings(mixed $val): bool
	{
		return (gettype($val) != 'string');
	}

	/**
	* checks if the search query matches any class attribute name
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/			
	protected function isAttribute(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$cfqns = [];
		$stackedDataArray = [];
		
		$cfqns = ($this->classesInspectorHelper)->cfqns;
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();
		
		$res = false;
		
		if (!empty($cfqns)) {
			
			foreach ($cfqns as $cfqn_key => $cfqn) {

				if (!empty($stackedDataArray[$cfqn_key]['attributes'])) {
			
					foreach ($stackedDataArray[$cfqn_key]['attributes'] as $att_name) {
			
						if  (strcmp($formatted_str,strtolower($att_name)) == 0) {
							
							$res = true;
							
							break;

						}
					}
				}
			}
		}
		
		return $res;
	}

	/**
	* checks if the search query matches any class constant name
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/
	protected function isConstant(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$cfqns = [];
		$stackedDataArray = [];
		
		$cfqns = ($this->classesInspectorHelper)->cfqns;
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();
		
		$res = false;
		
		if (!empty($cfqns)) {
		
			foreach ($cfqns as $cfqn_key => $cfqn) {

				if (!empty($stackedDataArray[$cfqn_key]['constants'])) {
			
					foreach ($stackedDataArray[$cfqn_key]['constants'] as $constant_name) {
			
						if  (strcmp($formatted_str,strtolower($constant_name)) == 0) {
							
							$res = true;

							break;
						}
					}
				}
			}
		}		
		return $res;
	}

	/**
	* checks if the search query matches any enum name
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/
	protected function isEnum(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$cfqns = [];
		$stackedDataArray = [];
		
		$cfqns = ($this->classesInspectorHelper)->cfqns;
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();
		
		$res = false;
		
		if (!empty($cfqns)) {
			
			foreach ($cfqns as $cfqn_key => $cfqn) {
			
				if  ( ($stackedDataArray[$cfqn_key]['is_enum'] === true) &&
				      (strcmp($formatted_str,strtolower($stackedDataArray[$cfqn_key]['short_name'])) == 0)     	
			        ) {		
				  	    $res = true;
						
						break;
				}
			}
		}				
		return $res;		
	}

	/**
	* checks if the search query matches any enum case value name
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/
	protected function isEnumCaseValue(string $searchTerm = " "): bool
	{
		
		$formatted_str = strtolower(trim($searchTerm));
		
		$cfqns = [];
		$stackedDataArray = [];
		
		$cfqns = ($this->classesInspectorHelper)->cfqns;
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();
		
		$res = false;		
		
		if (!empty($cfqns)) {
		
			foreach ($cfqns as $cfqn_key => $cfqn) {

				if (!empty($stackedDataArray[$cfqn_key]['enums_cases_values'])) {
			
					foreach ($stackedDataArray[$cfqn_key]['enums_cases_values'] as $enum_case_value) {
			
						if  (strcmp($formatted_str,strtolower($enum_case_value)) == 0) {		
							
							$res = true;
							
							break;
						}
					}
				}
			}
		}		
		return $res;				
	}

	/**
	* checks if the search query matches any enum case (string) backing value
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/	
	protected function isEnumCaseStringBackingValue(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$cfqns = [];
		$stackedDataArray = [];
		
		$cfqns = ($this->classesInspectorHelper)->cfqns;
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();

		$res = false;		
		
		if (!empty($cfqns)) {
		
			foreach ($cfqns as $cfqn_key => $cfqn) {

				if (!empty($stackedDataArray[$cfqn_key]['enums_cases_backing_values'])) {
			
					foreach ($stackedDataArray[$cfqn_key]['enums_cases_backing_values'] as $key => $enum_case_value) {
			
						if  ( (strcmp(gettype($enum_case_value),'string') == 0)  && (strcmp($formatted_str,strtolower($enum_case_value)) == 0) ) {		
							
							$res = true;
							
							break;
						}
					}
				}
			}
		}		
		return $res;	
	}

	/**
	* checks if the search query matches any reflection extension
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/
	protected function isExtension(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$cfqns = [];
		$stackedDataArray = [];
		
		$cfqns = ($this->classesInspectorHelper)->cfqns;
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();
		
		$res = false;		
		
		if (!empty($cfqns)) {
			
			foreach ($cfqns as $cfqn_key => $cfqn) {
				
				if  ( ($stackedDataArray[$cfqn_key]['reflection_extension_object_name'] != 'user defined class') &&
				      (strcmp($formatted_str,strtolower($stackedDataArray[$cfqn_key]['reflection_extension_object_name'])) == 0)     	
			        ) {		
						$res = true;
						
						break;
				}
			}
		}	
		return $res;			
	}

	/**
	* checks if the search query matches any reflection extension name
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/	
	protected function isExtensionName(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$cfqns = [];
		$stackedDataArray = [];
		
		$cfqns = ($this->classesInspectorHelper)->cfqns;
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();
		
		$res = false;		
			
		if (!empty($cfqns)) {
			
			foreach ($cfqns as $cfqn_key => $cfqn) {
				
				if  ( ($stackedDataArray[$cfqn_key]['reflection_extension_class_name'] != 'user defined class') &&
				      (strcmp($formatted_str,strtolower($stackedDataArray[$cfqn_key]['reflection_extension_class_name'])) == 0)     	
			        ) {		
						
						$res = true;
						
						break;
				}
			}
		}
		return $res;			
	}

	/**
	* checks if the search query matches the name of any instantiable class
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/			
	protected function isInstantiableClass(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$cfqns = [];
		$stackedDataArray = [];
		
		$cfqns = ($this->classesInspectorHelper)->cfqns;
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();
		
		$res = false;		
		
		if (!empty($cfqns)) {
			
			foreach ($cfqns as $cfqn_key => $cfqn) {
			
				if  ( ($stackedDataArray[$cfqn_key]['is_instantiable'] === true) &&
				      (strcmp($formatted_str,strtolower($stackedDataArray[$cfqn_key]['short_name'])) == 0)     	
			        ){	
					
					$res = true;

					break;
				}
			}
		}		
		return $res;			
	}

	/**
	* checks if the search query matches the name of any interface
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/
	protected function isInterface(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$cfqns = [];
		$stackedDataArray = [];
		
		$cfqns = ($this->classesInspectorHelper)->cfqns;
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();
		
		$res = false;		
		
		if (!empty($cfqns)) {
			
			foreach ($cfqns as $cfqn_key => $cfqn) {
			
				if  ( ($stackedDataArray[$cfqn_key]['is_interface'] === true) &&
				      (strcmp($formatted_str,strtolower($stackedDataArray[$cfqn_key]['short_name'])) == 0)     	
			        ) {		
					   
					   $res = true;
					   
					   break;
				    }
			}
		}
		
		return $res;		
	}	

	/**
	* checks if the search query matches the name of any iterable class
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/
	protected function isIterableClass(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$cfqns = [];
		$stackedDataArray = [];
		
		$cfqns = ($this->classesInspectorHelper)->cfqns;
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();
		
		$res = false;		
		
		if (!empty($cfqns)) {
			
			foreach ($cfqns as $cfqn_key => $cfqn) {
			
				if  ( ($stackedDataArray[$cfqn_key]['is_iterable'] === true) &&
				      (strcmp($formatted_str,strtolower($stackedDataArray[$cfqn_key]['short_name'])) == 0)     	
			        ) {
						
					$res = true;
					
					break;
				}
			}
		}		
		return $res;				
	}

	/**
	* checks if the search query matches the name of any class method
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/
	protected function isMethod(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$cfqns = [];
		$stackedDataArray = [];
		
		$cfqns = ($this->classesInspectorHelper)->cfqns;
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();
		
		$res = false;		
		
		if (!empty($cfqns)) {
		
			foreach ($cfqns as $cfqn_key => $cfqn) {

				if (!empty($stackedDataArray[$cfqn_key]['methods'])) {
			
					foreach ($stackedDataArray[$cfqn_key]['methods'] as $method_name) {
			
						if  (strcmp($formatted_str,strtolower($method_name)) == 0) {		
					       
						   $res = true; 
						   
						   break; 	
						}
					}
				}
			}
		}		
		return $res;	
	}

	/**
	* checks if the search query matches the name of any namespace
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/
	protected function isNamespace(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$cfqns = [];
		$stackedDataArray = [];
		
		$cfqns = ($this->classesInspectorHelper)->cfqns;
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();
		
		$res = false;		
		
		if (!empty($cfqns)) {
		
			foreach ($cfqns as $cfqn_key => $cfqn) {

				if (!empty($stackedDataArray[$cfqn_key]['namespace'])) {
			
					if  (strcmp($formatted_str,strtolower($this->stackedDataArray[$cfqn_key]['namespace'])) == 0) {		
					
						$res = true;
						
						break;
					}
				}
			}
		}		
		return $res;		
	}

	/**
	* checks if the search query matches the name of any class method parameter
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/
	protected function isParameter(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$cfqns = [];
		$stackedDataArray = [];
		
		$cfqns = ($this->classesInspectorHelper)->cfqns;
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();
		
		$res = false;		
		
		if (!empty($cfqns)) {
		
			foreach ($cfqns as $cfqn_key => $cfqn) {

				if (!empty($stackedDataArray[$cfqn_key]['parameters'])) {
			
					foreach ($stackedDataArray[$cfqn_key]['parameters'] as $parameter_name) {
			
						if  (strcmp($formatted_str,strtolower($parameter_name)) == 0) {		

					       $res = true;
						   
						   break;	
						}
					}
				}
			}
		}
		return $res;		
	}

	/**
	* checks if the search query matches the name of any class property
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/
	protected function isProperty(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$cfqns = [];
		$stackedDataArray = [];
		
		$cfqns = ($this->classesInspectorHelper)->cfqns;
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();
		
		$res = false;		
		
		if (!empty($cfqns)) {
		
			foreach ($cfqns as $cfqn_key => $cfqn) {

				if (!empty($stackedDataArray[$cfqn_key]['properties'])) {
			
					foreach ($stackedDataArray[$cfqn_key]['properties'] as $property_name) {
			
						if  (strcmp($formatted_str,strtolower($property_name)) == 0) {		

					        $res = true;
							
							break;
						}
					}
				}
			}
		}
		return $res;	
	}

	/**
	* checks if the search query matches the name of any trait alias
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/	
	protected function isTraitAlias(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$cfqns = [];
		$stackedDataArray = [];
		
		$cfqns = ($this->classesInspectorHelper)->cfqns;
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();
		
		$res = false;		
		
		if (!empty($cfqns)) {
		
			foreach ($cfqns as $cfqn_key => $cfqn) {

				if (!empty($stackedDataArray[$cfqn_key]['traits_aliases_names'])) {
			
					foreach ($stackedDataArray[$cfqn_key]['traits_aliases_names'] as $trait_alias_name) {
			
						if  (strcmp($formatted_str,strtolower($trait_alias_name)) == 0) {		

					       $res = true;
						   
						   break;
						   
						}
					}
				}
			}
		}
		return $res;		
	} 		

	/**
	* checks if the search query matches the name of any trait
	*
	* @param string $searchTerm
	*
	* @return bool
	*
	*/
	protected function isTrait(string $searchTerm = " "): bool
	{
		$formatted_str = strtolower(trim($searchTerm));
		
		$cfqns = [];
		$stackedDataArray = [];
		
		$cfqns = ($this->classesInspectorHelper)->cfqns;
		$stackedDataArray =  ClassesInspectorHelper::getArrayData();
		
		$res = false;		

		if (!empty($cfqns)) {
		
			foreach ($cfqns as $cfqn_key => $cfqn) {

				if (!empty($stackedDataArray[$cfqn_key]['traits'])) {
			
					foreach ($stackedDataArray[$cfqn_key]['traits'] as $trait_name) {
			
						if  (strcmp($formatted_str,strtolower($trait_name)) == 0) {		

					       $res = true;
						   
						    break;
						}
					}
				}
			}
		}
		return $res;				
	}

}
