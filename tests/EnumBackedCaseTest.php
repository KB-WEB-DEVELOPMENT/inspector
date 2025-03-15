<?php

use Inspector\Controller;

use PHPUnit\Framework\TestCase;

class EnumBackedCaseTest extends TestCase	
{
	public function testBackedCaseTestFound(): void
    {
		$searchTerm = 'TestEnumBackedCase2 value';
		
		$result = Controller::find($searchTerm);
		
        $this->assertContains('Data type: Enum string case backing value',$result);
    }
	
	public function testBackedCaseTestNotFound(): void
    {
		$searchTerm = 'wrong enum backed case value';
		
		$result = Controller::find($searchTerm);
		
        $this->assertNotContains('Data type: Enum string case backing value',$result); 
    } 
}