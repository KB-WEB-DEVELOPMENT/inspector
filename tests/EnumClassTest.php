<?php

use Inspector\Controller;

use PHPUnit\Framework\TestCase;

class EnumClassTest extends TestCase	
{
	public function testEnumClassFound(): void
    {
		$searchTerm = 'TestEnum';
		
		$result = Controller::find($searchTerm);
		
        $this->assertContains('Data type: Enum',$result);
    }
	
	public function testEnumClassNotFound(): void
    {
		$searchTerm = 'WrongTestEnum';
		
		$result = Controller::find($searchTerm);
		
        $this->assertNotContains('Data type: Enum',$result); 
    }    
}