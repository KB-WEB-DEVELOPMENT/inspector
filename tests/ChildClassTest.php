<?php

use Inspector\Controller;

use PHPUnit\Framework\TestCase;

class ChildClassTest extends TestCase	
{
    public function testChildClassFound(): void
    {
	 $searchTerm = 'TestChildClass';
		
	 $result = Controller::find($searchTerm);
		
         $this->assertContains('Class short name: TestChildClass',$result);
    }
	
    public function testChildClassNotFound(): void
    {
       $searchTerm = 'wrongTestChildClass';
		
       $result = Controller::find($searchTerm);
		
       $this->assertNotContains('Class short name:',$result); 
    }    
}
