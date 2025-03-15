# Table of contents
1. [**Project Description**](#description)
2. [**Installation**](#installation)
3. [**Usage**](#usage)
4. [**License**](#license)

## 1. Project Description <a name="description"></a>

(Ongoing work)

Project to explore PHP Reflection API classes.

**https://www.php.net/manual/en/book.reflection.php**

The package tries to determine if a case-insensitive string entered by a user matches one or many of the following: 

1. An existing abstract class name
2. An existing attribute name
3. An existing constant name
4. An existing Enum name 
5. An existing Enum case name 
6. An existing Enum backing type string value 
7. An existing ReflectionExtension object name
8. The name of an existing extension which defines one of PHP API Reflection classes
9. The name of any existing user-defined instantiable class 
10. An existing interface name 
11. The name of an existing iterable class
12. An existing method name 
13. An existing namespace name
14. An existing method parameter name 
15. An existing class property name
16. An existing trait alias name
17. An existing trait name
18. An array named key present in any existing one-dimensional associative array 
19. An array string value present in any existing one-dimensional associative array 

All the classes as well as some of the methods used in the package:

![PHP API Reflection classes used in the project.](https://i.imghippo.com/files/zoi7058iAU.png 'PHP API Reflection classes used in the project')

## 2. Installation <a name="installation"></a>

1. Open Git Bash.

2. Change the current working directory to the location where you want the cloned directory.

3. Type: `git clone https://github.com/KB-WEB-DEVELOPMENT/inspector`

4. Type: `composer install` 

## 3. Usage <a name="usage"></a>

All your classes and associative arrays should be put in the src/Project folder:

![Package directory structure.](https://i.postimg.cc/jdJGC60f/inspector-project.png 'Package directory structure')


```
<?php

//  In your examples/index.php file, import the Controller class present in the 'src/' directory

require __DIR__ . '/../vendor/autoload.php';

use Inspector\Controller;

$searchTerm = 'some case-insensitive string to be searched by PHP Reflection API classes';
		
// $result data type: 'string'
$result = Controller::find($searchTerm); 

?>
```

## 4. License <a name="license"></a>

The MIT License (MIT)

Copyright (c) <2024> Kâmi Barut-Wanayo

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
