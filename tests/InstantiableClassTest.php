<?php

use Inspector\Controller;

use PHPUnit\Framework\TestCase;

class InstantiableClassTest extends TestCase	
{
    public function testInstantiableClassFound(): void
    {
		$searchTerm = 'TestInstantiableClass';
		
		$result = Controller::find($searchTerm);
		
        $this->assertContains('Data type: Instantiable class',$result);
    }
	
    public function testInstantiableClassNotFound(): void
    {
		$searchTerm = 'WrongTestInstantiableClass';
		
		$result = Controller::find($searchTerm);
		
        $this->assertNotContains('Data type: Instantiable class',$result); 
    }
}
