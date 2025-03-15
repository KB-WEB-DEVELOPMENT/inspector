<?php

use Inspector\Controller;

use PHPUnit\Framework\TestCase;

class ArrayStringKeysTest extends TestCase	
{
    public function testStringKeyFound(): void
    {
       $searchTerm = 'key1';
		
       $result = Controller::find($searchTerm);
		
       $this->assertContains('Data type: Array named key',$result);
    }
	
    public function testStringKeyNotFound(): void
    {
       $searchTerm = 'wrongKey';
		
       $result = Controller::find($searchTerm);
		
       $this->assertNotContains('Data type: Array named key',$result); 
    }  
}
