<?php

namespace Inspector\Helpers;

class ClassesInspectorHelper
{    	
    /**
    * Classes fully qualified names (= cfqns) 
    *
    * @var array
    */
    protected array $cfqns = []; 
	
    /**
    * An array used to store all classes data by data type
    *
    * @var array
    */	
    protected array $stackedDataArray = [];
	
    public function __construct() {	
	
       $this->cfqns = ClassesHelper::getClassesFullyQualifiedNames();
     }

	/**
	* 
	* retrieves array used to store all classes data by data type
	*
	* @return array
	*/		
     public static function getArrayData(): array
     {
		$this->storeAttributes();
		$this->storeClassesSubclassOf();
		$this->storeConstants();
		$this->storeDocComments();
		$this->storeEndLines();
		$this->storeEnumsCases();
		$this->storeEnumsCasesBackingValues();
		$this->storeExtensions();
		$this->storeExtensionNames();
		$this->storeFilenames();
		$this->storeFullyQualifiedNames();
		$this->storeInterfaces();
		$this->storeIsChecks();
		$this->storeMethods();
		$this->storeNames();
		$this->storeNamespaces();
		$this->storeParameters();
		$this->storeParentClasses();
		$this->storeProperties();
		$this->storeShortNames();
		$this->storeStartLines();
		$this->storeTraitsAliases()
		$this->storeTraits();
		
		return $this->stackedDataArray;
	}

	/**
	* stores all attributes
	*
	* @return void
	*/	
	protected function storeAttributes(): void
	{
		$attributes_arr = [];
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
								
				$attributes_arr[$cfqn_key] = new ReflectionClass($cfqn)->getAttributes() ?? null; 										
			}			
		}
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
				
				if (!empty($attributes_arr[$cfqn_key])) {
					
					foreach ($attributes_arr[$cfqn_key] as $att) {
					
						$this->stackedDataArray[$cfqn_key]['attributes'][] = $att->getName();	
					
					}
				
				} else {

					$this->stackedDataArray[$cfqn_key]['attributes'] = null;	
				}		
			}			
		}
	}

	/**
	* determines and stores relations between all child classes and their parent classes 
	*
	* @return void
	*/
	protected function storeClassesSubclassOf(): void
	{
		$parent_tmp_arr = [];
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $child_cfqn_key => $child_cfqn) {
				
				$this->stackedDataArray[$child_cfqn_key]['subclass_of'] = null;
				
				$parent_tmp_arr = unset($this->cfqns[$child_cfqn_key]);
				
				foreach ($parent_tmp_arr as $parent_cfqn) {
					
					if (new ReflectionClass($child_cfqn)->isSubclassOf($parent_cfqn)) { 
								
						$this->stackedDataArray[$child_cfqn_key]['subclass_of'] = $parent_cfqn;        			
					}			
				}
				unset($parent_tmp_arr);
			}
		}
	}

	/**
	* stores all classes constants
	*
	* @return void
	*/
	protected function storeConstants(): void
	{		
		$unsorted_consts = [];
		
		if (!empty($this->cfqns)) {
					
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
								
				$unsorted_consts[$cfqn_key] = new ReflectionClass($cfqn)->getConstants() ?? null;
			}	
		} 
				
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
				
				$this->stackedDataArray[$cfqn_key]['constants'] = $unsorted_consts[$cfqn_key];						
			}	
		}
	}	

	/**
	* stores all classes Doc Comments
	*
	* @return void
	*/
	protected function storeDocComments(): void
	{
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
								
				$this->stackedDataArray[$cfqn_key]['doc_comment'] = (new ReflectionClass($cfqn)->getDocComment()===false) ? 'unavailable' : new ReflectionClass($cfqn)->getDocComment();
	
			}				
		}
	}

	/**
	* stores all classes end line number if it exists
	*
	* @return void
	*/
	protected function storeEndLines(): void
	{
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
				
				$this->stackedDataArray[$cfqn_key]['end_line'] = (new ReflectionClass($cfqn)->getEndLine()===false) ? 'unavailable' : new ReflectionClass($cfqn)->getEndLine();
			}				
		}
	}

	/**
	* stores all enums cases
	*
	* @return void
	*/	
	protected function storeEnumsCases(): void
	{	

		$enums_obj_arr = [];
		$enums_cases_arr = [];
		$formatted_enums_cases_arr = [];
		$cases_names_arr = [];

		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
								
				$enums_obj_arr[$cfqn_key] = (new ReflectionClass($cfqn)->isEnum() === true) ? new ReflectionEnum($cfqn) : null;
			}
		}
		
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
				
				if ( (!empty($enums_obj_arr[$cfqn_key]))  && (!empty($enums_obj_arr[$cfqn_key]->getCases())) ) {
					
					$enums_cases_arr[$cfqn_key] = $enums_obj_arr[$cfqn_key]->getCases();		
					
				} else {
					
					$enums_cases_arr[$cfqn_key] = [];
				}	
			}				
		}

		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
				
				if (!empty($enums_cases_arr[$cfqn_key])) {
					
					foreach ($enums_cases_arr[$cfqn_key] as $case) {
					
						$formatted_enums_cases_arr[$cfqn_key] = (array)$case->getValue();	
					}
					
				} else {
					
					$formatted_enums_cases_arr[$cfqn_key] = null;
				}	
			}				
		}
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
				
				if (!empty($formatted_enums_cases_arr[$cfqn_key])) {
					
					foreach ($formatted_enums_cases_arr[$cfqn_key] as $arr) {
					
						$cases_names_arr[$cfqn_key] = $arr['name']);		
					
					}
					
				} else {
					
					$cases_names_arr[$cfqn_key] = null;
				}	
			}				
		}

		if (!empty($this->cfqns)) {

			foreach ($this->cfqns as $cfqn_key => $cfqn) {
				
				if (!empty($cases_names_arr[$cfqn_key])) {
				
					foreach ($cases_names_arr[$cfqn_key] as $name) {
					
						$this->stackedDataArray[$cfqn_key]['enums_cases_values'][] = $name;		
					}
					
				} else {
					
					$this->stackedDataArray[$cfqn_key]['enums_cases_values'] = null;						
				}	
			}
		}		
	}

	/**
	* stores all enums cases backing values
	*
	* @return void
	*/
	protected function storeEnumsCasesBackingValues(): void
	{		
		$enums_obj_arr = [];
		$backed_enums_obj_arr = [];
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
								
				$enums_obj_arr[$cfqn_key] = (new ReflectionClass($cfqn)->isEnum() === true) ? new ReflectionEnum($cfqn) : null;
			}
		}
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
								
				if ( (!empty($enums_obj_arr[$cfqn_key])) && (($enums_obj_arr[$cfqn_key])->isBacked()) ) {
					
					$backed_enums_obj_arr[$cfqn_key] = new ReflectionEnum($cfqn);
				
				} else {

					$backed_enums_obj_arr[$cfqn_key] = null;		
				}
			}	
		}
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
		
				if ( (!empty($backed_enums_obj_arr[$cfqn_key])) && (!empty($this->stackedDataArray[$cfqn_key]['enums_cases_values'])) ) {
					
					foreach ($this->stackedDataArray[$cfqn_key]['enums_cases_values'] as $case_name) {
					
						$this->stackedDataArray[$cfqn_key]['enums_cases_backing_values'][] = $case_name;	
					}
				
				} else {
					
					$this->stackedDataArray[$cfqn_key]['enums_cases_backing_values'] = null;		
				}
			}
		}			
	}

	/**
	* stores all classes extensions object names
	*
	* @return void
	*/
	protected function storeExtensions(): void
	{
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
				
				$this->stackedDataArray[$cfqn_key]['reflection_extension_object_name'] = (is_null(new ReflectionClass($cfqn)->getExtension())) ? 'user defined class' : (new ReflectionClass($cfqn)->getExtension())->name;
			}				
		}
	}

	/**
	* stores all classes extensions names
	*
	* @return void
	*/
	protected function storeExtensionNames(): void
	{		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
				
				$this->stackedDataArray[$cfqn_key]['reflection_extension_class_name'] = (new ReflectionClass($cfqn)->getExtensionName()===false) ? 'user defined class' : new ReflectionClass($cfqn)->getExtensionName();
			}				
		}
	}

	/**
	* stores all filenames (exact file locations)
	*
	* @return void
	*/
	protected function storeFilenames(): void
	{
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
				
				$this->stackedDataArray[$cfqn_key]['filename'] = (new ReflectionClass($cfqn)->getFileName()===false) ? 'PHP core class or PHP extension' : new ReflectionClass($cfqn)->getFileName();
			}				
		}		
	}

	/**
	* stores all classes fully qualified names 
	*
	* @return void
	*/
	protected function storeFullyQualifiedNames(): void
	{
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
				
				$this->stackedDataArray[$cfqn_key]['cfqn'] = $cfqn;
			}				
		}
	}

	/**
	* stores all interfaces
	*
	* @return void
	*/
	protected function storeInterfaces(): void
	{
		$unsorted_ints = [];
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
														
				$unsorted_ints[$cfqn_key] = new ReflectionClass($cfqn)->getInterfaceNames() ?? null;		
			}
		}
	
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
			
				$this->stackedDataArray[$cfqn_key]['interfaces'] = $unsorted_ints[$cfqn_key];		
		
			}
		}					
	}

	/**
	* stores all classes specific infos
	*
	* @return void
	*/	
	protected function storeIsChecks(): void
	{
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
				
				$this->stackedDataArray[$cfqn_key]['is_abstract'] = new ReflectionClass($cfqn)->isAbstract();
				$this->stackedDataArray[$cfqn_key]['is_anonymous'] = new ReflectionClass($cfqn)->isAnonymous();
				$this->stackedDataArray[$cfqn_key]['is_cloneable'] = new ReflectionClass($cfqn)->isCloneable();
				$this->stackedDataArray[$cfqn_key]['is_enum'] = new ReflectionClass($cfqn)->isEnum();
				$this->stackedDataArray[$cfqn_key]['is_final'] = new ReflectionClass($cfqn)->isFinal();
				$this->stackedDataArray[$cfqn_key]['is_instantiable'] = new ReflectionClass($cfqn)->isInstantiable();
				$this->stackedDataArray[$cfqn_key]['is_interface'] = new ReflectionClass($cfqn)->isInterface();
				$this->stackedDataArray[$cfqn_key]['is_internal'] = new ReflectionClass($cfqn)->isInternal();
				$this->stackedDataArray[$cfqn_key]['is_iterable'] = new ReflectionClass($cfqn)->isIterable();
				$this->stackedDataArray[$cfqn_key]['is_readonly'] = new ReflectionClass($cfqn)->isReadonly();
				$this->stackedDataArray[$cfqn_key]['is_trait'] = new ReflectionClass($cfqn)->isTrait();
				$this->stackedDataArray[$cfqn_key]['is_userdefined'] = new ReflectionClass($cfqn)->isUserDefined();				
			}				
		}	
    }

	/**
	* stores all classes methods names
	*
	* @return void
	*/	
	protected function storeMethods(): void
	{		
		$methods_arr = [];
		$unsorted_methods_arr = [];
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
									
				$methods_arr[$cfqn_key] = new ReflectionClass($cfqn)->getMethods() ?? null;					
			}	
		}
		
		if (!empty($this->cfqns)) { 
		
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
								
				if (!empty($methods_arr[$cfqn_key])) {
				
					foreach ($methods_arr[$cfqn_key] as $value) {
						
						$unsorted_methods_arr[$cfqn_key][] = $value['name'];	
					}				
				
				} else {
					
					$unsorted_methods_arr[$cfqn_key] = null;
				}	
				
			}	
		}
							
		if (!empty($this->cfqns)) { 
		
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
												
				$this->stackedDataArray[$cfqn_key]['methods'] = $unsorted_methods_arr[$cfqn_key];				
			}
		}
			
	}

	/**
	* stores all classes names including the namespace  
	*
	* @return void
	*/	
	protected function storeNames(): void
	{
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
				
				$this->stackedDataArray[$cfqn_key]['name'] = new ReflectionClass($cfqn)->getName();
			}				
		}	
	}

	/**
	* stores all namespaces
	*
	* @return void
	*/
	protected function storeNamespaces() :void
	{
		$namespaces = [];

		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
								
				$namespaces[$cfqn_key] = (new ReflectionClass($cfqn)->inNamespace() === true) ? new ReflectionClass($cfqn)->getNamespaceName() : null;
			
				$this->stackedDataArray[$cfqn_key]['namespace'] = $namespaces[$cfqn_key];
			}
		}			
	}

	/**
	* stores all parameters names contained in all classes methods  
	*
	* @return void
	*/
	protected function storeParameters(): void
	{			
		$refl_meth_obj_arr = [];
		$params = [];
			
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
			
				if (!empty($this->stackedDataArray[$cfqn_key]['methods'])) {
										
					foreach ($this->stackedDataArray[$cfqn_key]['methods'] as $method_name) {
						
						$refl_meth_obj_arr[$cfqn_key][] = new ReflectionMethod($cfqn,$method_name);	
					}	
											
				} else {
					
					$refl_meth_obj_arr[$cfqn_key] = null;
				}
			}
		}

		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
			
				if (!empty($refl_meth_obj_arr[$cfqn_key])) {
										
					foreach ($refl_meth_obj_arr[$cfqn_key] as $refl_meth_obj) {
						
						$params[$cfqn_key] =  ( (count($refl_meth_obj->getParameters())) > 0 ) ? $refl_meth_obj->getParameters() : null;								
					}	
				}		
			}
		}
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
			
				if (!empty($params[$cfqn_key])) {
										
					foreach ($params[$cfqn_key] as $param) {
						
						$this->stackedDataArray[$cfqn_key]['parameters'][] = $param->getName();													
					}	

				} else {

					$this->stackedDataArray[$cfqn_key]['parameters'] = null;
				}			
			}
		}
	}

	/**
	* stores parent class name for all instantiable classes
	*
	* @return void
	*/
	protected function storeParentClasses(): void
	{				
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
							
				$this->stackedDataArray[$cfqn_key]['parent_class_name'] = (new ReflectionClass($cfqn)->getParentClass() === false) ? null : new ReflectionClass($cfqn)->getParentClass()->getName(); 
			}
		}
	}

	/**
	* stores all properties of all classes
	*
	* @return void
	*/
	protected function storeProperties(): void
	{
		$properties_arr = [];
		$unsorted_properties_arr = [];
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
													
				$properties_arr[$cfqn_key] = new ReflectionClass($cfqn)->getProperties() ?? null;		
			}
		}
		
		if (!empty($this->cfqns)) { 
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
								
				if (!empty($properties_arr[$cfqn_key])) {
				
					foreach ($properties_arr[$cfqn_key] as $value) {
						
						$unsorted_properties_arr[$cfqn_key][] = $value['name'];	
					}				
				
				} else {
					
					$unsorted_properties_arr[$cfqn_key] = null;
				}	
				
			}	
		}
				
		if (!empty($this->cfqns)) { 
		
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
												
				$this->stackedDataArray[$cfqn_key]['properties'] = $unsorted_properties_arr[$cfqn_key];				
			}
		}
	}

	/**
	* stores all unqualified classes names 
	*
	* @return void
	*/
	protected function storeShortNames(): void
	{
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
				
				$this->stackedDataArray[$cfqn_key]['short_name'] = new ReflectionClass($cfqn)->getShortName();
			}				
		}
	}

	/**
	* stores the number of each class first line 
	*
	* @return void
	*/
	protected function storeStartLines(): void
	{
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
				
				$this->stackedDataArray[$cfqn_key]['start_line'] = (new ReflectionClass($cfqn)->getStartLine()===false) ? 'unavailable' : new ReflectionClass($cfqn)->getStartLine();
			}				
		}
	}

	/**
	* stores all trait alias names
	*
	* @return void
	*/	
	protected function storeTraitsAliases(): void
	{
		
		$trait_arr = [];
		$arr1 = [];
		$arr2 = [];
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
								
				$trait_arr[$cfqn_key] = new ReflectionClass($cfqn)->getTraitAliases() ?? null; 										
			}
		}
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {

				if (!empty($trait_arr[$cfqn_key])) {
					
					foreach ($trait_arr[$cfqn_key] as $arr) {
					
						$arr1[$cfqn_key] =  array_keys($arr));
					
						$arr2[$cfqn_key] =  array_values($arr));
					}
				
				  //else statement actually not needed
				
				} else {
					
					$arr1[$cfqn_key] = [];
					
					$arr2[$cfqn_key] = [];
				}	
				
			}
		}
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {

				if (!empty($arr1[$cfqn_key])) {
					
					foreach ($arr1[$cfqn_key] as $key => $value) {
					
						$this->stackedDataArray[$cfqn_key]['traits_aliases_names'][] = $value;	
					
					}
				
				} else {

					$this->stackedDataArray[$cfqn_key]['traits_aliases_names'] = null;	
				}
			}	
		}
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {

				if (!empty($arr2[$cfqn_key])) {
					
					foreach ($arr2[$cfqn_key] as $key => $value) {
					
						$this->stackedDataArray[$cfqn_key]['traits_original_names'][] = $value;	
					
					}
				
				} else {

					$this->stackedDataArray[$cfqn_key]['traits_original_names'] = null;	
				}
			}	
		}
		
		// unset method actually not needed
		
		unset($arr1);
		unset($arr2);

	}	

	/**
	* stores all trait names
	*
	* @return void
	*/
	protected function storeTraits(): void
	{
		$traits_arr = [];
		$unsorted_traits_arr = [];
		
		if (!empty($this->cfqns)) {
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
									
				$traits_arr[$cfqn_key] = new ReflectionClass($cfqn)->getTraits() ?? null;		
			}
		}
		
		if (!empty($this->cfqns)) { 
			
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
								
				if (!empty($traits_arr[$cfqn_key])) {
				
					foreach ($traits_arr[$cfqn_key] as $value) {
						
						$unsorted_traits_arr[$cfqn_key][] = $value['name'];	
					}				
				
				  //else statement actually not needed
				
				} else {
					
					$unsorted_traits_arr[$cfqn_key] = null;
				}	
				
			}	
		}
		
		if (!empty($this->cfqns)) { 
		
			foreach ($this->cfqns as $cfqn_key => $cfqn) {
												
				$this->stackedDataArray[$cfqn_key]['traits'] = $unsorted_traits_arr[$cfqn_key];				
			}
		}
	}
}
