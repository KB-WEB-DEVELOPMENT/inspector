<?php

use Inspector\Controller;

use PHPUnit\Framework\TestCase;

class EnumUnitCaseTest extends TestCase	
{
    public function testEnumUnitTestFound(): void
    {
	$searchTerm = 'TestEnumCase3';
		
	$result = Controller::find($searchTerm);
		
        $this->assertContains('Data type: Enum case value',$result);
    }
	
    public function testEnumUnitTestNotFound(): void
    {
	$searchTerm = 'wrongTestEnumCase';
		
	$result = Controller::find($searchTerm);
		
        $this->assertNotContains('Data type: Enum case value',$result); 
    } 
}
