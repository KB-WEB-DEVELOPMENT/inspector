<?php

use Inspector\Controller;

use PHPUnit\Framework\TestCase;

class AbstractClassTest extends TestCase	
{
    public function testAbstractClassFound(): void
    {
        $searchTerm = 'TestAbstractClass';
		
		$result = Controller::find($searchTerm);
		
        $this->assertContains('Data type: Abstract class',$result);
    }
	
    public function testAbstractClassNotFound(): void
    {
        $searchTerm = 'WrongAbstractClass';
		
		$result = Controller::find($searchTerm);
		
        $this->assertNotContains('Data type: Abstract class',$result); 
    }
}
