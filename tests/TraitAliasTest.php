<?php

use Inspector\Controller;

use PHPUnit\Framework\TestCase;

class TraitAliasTest extends TestCase	
{
    public function testTraitAliasFound(): void
    {
	$searchTerm = 'aliasedTestTraitMethod';
		
	$result = Controller::find($searchTerm);
		
        $this->assertContains('Data type: Trait Alias',$result);
    }
	
    public function testTraitAliasNotFound(): void
    {
	$searchTerm = 'WrongAliasedTestTraitMethod';
		
	$result = Controller::find($searchTerm);
		
        $this->assertNotContains('Data type: Trait Alias',$result); 
    }    
}
