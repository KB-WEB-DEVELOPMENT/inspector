<?php

namespace Inspector;

interface InspectorInterface {
	
    public function find(string $searchTerm = " "): bool;
	
    public function getPrintingData(string $searchTerm = " "): ?array;
    
    public function printData(string $searchTerm = " "): ?string;
}

?>
