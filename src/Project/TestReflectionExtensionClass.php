<?php

namespace Inspector\Project;

class TestReflectionExtensionClass extends ReflectionClass
{
    public function __construct(object|string $testObjOrStr) {
      
       parent::__construct($objOrStr);  
    }
}

?>