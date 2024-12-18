<?php

namespace Inspector;

class Controller {
	
    public function __construct()
    {}

	/**
	* queries all classes and arrays for the search term.
	*
	* @param  string  $searchTerm
	* 
	* @return string
	*/
    static function find(string $searchTerm): string
    {		
		$absi  = new AbstractClassesInspector();	
		$anki = new ArrayNamedKeysInspector();
		$asvi = new ArrayStringValuesInspector();
		$atti = new AttributesInspector();
		$coni = new ConstantsInspector();
		$ecsbvi	= new EnumsCasesStringBackingValuesInspector();
		$ecvi = new EnumsCasesValuesInspector();
		$enumi = new EnumsInspector();
		$exi = new ExtensionsInspector();
		$eni = new ExtensionsNamesInspector();
		$ici = new InstantiableClassesInspector();
		$inti = new InterfacesInspector();
		$iti = new IterableClassesInspector();
		$mei = new MethodsInspector();
		$nsi = new NamespacesInspector();
		$pari = new ParametersInspector();
		$propi = new PropertiesInspector();
		$traitsali = new TraitsAliasesInspector();
		$traiti = new TraitsInspector();
		
		$formatted_str = $absi->printData($searchTerm);
		$formatted_str .= $anki->printData($searchTerm);
		$formatted_str .= $asvi->printData($searchTerm);
		$formatted_str .= $atti->printData($searchTerm);
		$formatted_str .= $coni->printData($searchTerm);
		$formatted_str .= $ecsbvi->printData($searchTerm);
		$formatted_str .= $ecvi->printData($searchTerm);
		$formatted_str .= $enumi->printData($searchTerm);
		$formatted_str .= $exi->printData($searchTerm);
		$formatted_str .= $eni->printData($searchTerm);
		$formatted_str .= $ici->printData($searchTerm);
		$formatted_str .= $inti->printData($searchTerm);
		$formatted_str .= $iti->printData($searchTerm);
		$formatted_str .= $mei->printData($searchTerm);
		$formatted_str .= $nsi->printData($searchTerm);
		$formatted_str .= $pari->printData($searchTerm);
		$formatted_str .= $propi->printData($searchTerm);
		$formatted_str .= $traitsali->printData($searchTerm);
		$formatted_str .= $traiti->printData($searchTerm);
		
		return $formatted_str ?? 'The search query you entered was not detected.';
    }
}