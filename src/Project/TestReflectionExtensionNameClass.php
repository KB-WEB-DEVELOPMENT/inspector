<?php

namespace Inspector\Project;

class TestReflectionExtensionNameClass extends ReflectionClass
{
    public function __construct(object|string $testObjOrStr) {
      
       parent::__construct($objOrStr);  
    }
}

?>