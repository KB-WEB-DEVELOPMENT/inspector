<?php

use Inspector\Controller;

use PHPUnit\Framework\TestCase;

class InterfaceTest extends TestCase	
{
	public function testInterfaceFound(): void
    {
		$searchTerm = 'TestInterface';
		
		$result = Controller::find($searchTerm);
		
        $this->assertContains('Data type: Interface',$result);
    }
	
	public function testInterfaceNotFound(): void
    {
		$searchTerm = 'WrongTestInterface';
		
		$result = Controller::find($searchTerm);
		
        $this->assertNotContains('Data type: Interface',$result); 
    }	
}