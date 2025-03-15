<?php

use Inspector\Controller;

use PHPUnit\Framework\TestCase;

use Inspector\Project\TestReflectionExtensionNameClass;

class ReflectionExtensionNameClassTest extends TestCase	
{		
	public function testReflectionExtensionNameClassFound(): void
    {
		$testReflNameObj = new TestReflectionExtensionNameClass('ReflectionMethod');

		$extension_name = $testReflNameObj->getExtensionName();
		
		$this->assertEquals('Reflection',$extension_name);

		$searchTerm = 'Reflection';
		
		$result = Controller::find($searchTerm);
		
        $this->assertContains('Data type: Reflection Extension Name',$result);
    }
	
	public function testReflectionExtensionNameClassNotFound(): void
    {
		$searchTerm = 'WrongReflection';
		
		$result = Controller::find($searchTerm);
		
        $this->assertNotContains('Data type: Reflection Extension Name',$result); 
    }
}