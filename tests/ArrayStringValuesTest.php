<?php

use Inspector\Controller;

use PHPUnit\Framework\TestCase;

class ArrayStringValuesTest extends TestCase	
{
    public function testStringValueFound(): void
    {
       $searchTerm = 'value1';
		
       $result = Controller::find($searchTerm);
		
       $this->assertContains('Data type: Array string value',$result);
    }
	
    public function testStringValueNotFound(): void
    {
        $searchTerm = 'wrongValue';
		
        $result = Controller::find($searchTerm);
		
        $this->assertNotContains('Data type: Array string value',$result); 
    }     
}
