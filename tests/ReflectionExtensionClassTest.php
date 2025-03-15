<?php

use Inspector\Controller;

use PHPUnit\Framework\TestCase;

use Inspector\Project\TestReflectionExtensionClass;

class ReflectionExtensionClassTest extends TestCase	
{
		
    public function testReflectionExtensionClassFound(): void
    {
	$testReflObj = new TestReflectionExtensionClass('ReflectionParameter');

	$extension_name = $testReflObj->getExtension()->name;
		
	$this->assertEquals('Reflection',$extension_name);

	$searchTerm = 'Reflection';
		
	$result = Controller::find($searchTerm);
		
        $this->assertContains('Data type: Reflection extension',$result);
    }
	
    public function testReflectionExtensionClassNotFound(): void
    {
	$searchTerm = 'WrongReflection';
		
	$result = Controller::find($searchTerm);
		
        $this->assertNotContains('Data type: Reflection extension',$result); 
    }
}
