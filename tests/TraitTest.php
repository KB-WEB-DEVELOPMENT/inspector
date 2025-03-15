<?php

use Inspector\Controller;

use PHPUnit\Framework\TestCase;

class TraitTest extends TestCase	
{
    public function testTraitFound(): void
    {
	$searchTerm = 'TestOriginalTrait';
		
	$result = Controller::find($searchTerm);
		
        $this->assertContains('Data type: Trait',$result);
    }
	
    public function testTraitNotFound(): void
    {
	$searchTerm = 'WrongTestOriginalTrait';
		
	$result = Controller::find($searchTerm);
		
        $this->assertNotContains('Data type: Trait',$result); 
    }     
}
