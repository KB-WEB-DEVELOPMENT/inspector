<?php

use Inspector\Controller;

use PHPUnit\Framework\TestCase;

class IterableClassTest extends TestCase	
{
    public function testIterableClassFound(): void
    {
	$searchTerm = 'TestIterableClass';
		
	$result = Controller::find($searchTerm);
		
        $this->assertContains('Data type: Iterable class',$result);
    }
	
    public function testIterableClassNotFound(): void
    {
	$searchTerm = 'WrongTestIterableClass';
		
	$result = Controller::find($searchTerm);
		
        $this->assertNotContains('Data type: Iterable class',$result); 
    }   
}
