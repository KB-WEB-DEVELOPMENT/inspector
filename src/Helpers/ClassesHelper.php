<?php

namespace Inspector\Helpers;

use PhpToken;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class ClassesHelper
{    
	public function __construct() {	
	}
	
	/**
	*
	* Retrieves all classes fully qualified names inside src/Project, its directories and subdirectories
	*
	* @return array
        *
	* @return void
	*
	*/
	static function getClassesFullyQualifiedNames(): array
	{
		$classes_fully_qualified_names = [];		
		
		$project_dirs = [];
								
		$project_dirs = $this->getDirectoriesList();
		
		if(!empty($project_dirs))  {
		
			foreach ($project_dirs as $dir_name) {
																
				$classes_fully_qualified_names[] = $this->getClassNamesFromDirectory($dir_name);
			}			
		}
		
		return $classes_fully_qualified_names;
	}	
	
	/**
	*
	* Retrieves an array of all directories and subdirectories within the src/Project folder
	*
	* @return array
        *
	*/
	private function getDirectoriesList(): array 
        {
	   $path = __DIR__ . '/../project'; 
		
	   $array_of_dirs = [];
	
	   $array_of_dirs[] = $path;
	
	   $iter = new RecursiveIteratorIterator(
			   new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
			   RecursiveIteratorIterator::SELF_FIRST,
			   RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
		    );
					
	   if(!empty($iter))  {
	
	        foreach ($iter as $path => $dir) {
	
		   if ($dir->isDir()) {

		       $array_of_dirs[] = $path;
		   }
		 }
	    }
	
	    return $array_of_dirs;
	}
	
	/**
	*
	* Retrieves all fully qualified classes names contained in all files within a directory
	*
	* @return array
        *
	*/
	private function getClassNamesFromDirectory(string $directory): array
        {
             $modelClassNames = [];
        
	      foreach (new RecursiveIteratorIterator(
			   new RecursiveDirectoryIterator(
				$directory, RecursiveDirectoryIterator::SKIP_DOTS |
				RecursiveDirectoryIterator::CURRENT_AS_SELF)) as $file
		      ) {				
			   $parts = [];
					
			   $parts = explode(".",$file);

			   $extension = (is_array($parts) && count($parts) > 1) ? end($parts) : null;
					
			    if ( (!is_null($extension)) && ((new SplFileInfo($file))->getExtension() === 'php') ) {
																		
				$modelClassNames = array_merge($modelClassNames, $this->getClassNamesFromFile($file->getPathName()));
				
			    }
		      }
		
                      return $modelClassNames;
        }

	/**
	*
	* Passes the content of a file to the method getClassNamesFromContent(string $content)
	* in order to retrieve the fully qualified class name(s ?) of that file.
	*
	* @return array
        *
	*/
        private function getClassNamesFromFile(string $file): array
        {											
            return $this->getClassNamesFromContent(file_get_contents($file));
        }
	
	/**
	* Determines and returns the fully qualified class name(s ?) from the content of a file 
	*
	* @param string $content
	*
	* @return array
	*/
        private function getClassNamesFromContent(string $content): array
        {
            // https://stackoverflow.com/a/67099502/2263114
            $classes = [];
            $namespace = '';
            $tokens = PhpToken::tokenize($content);
            $content = null;

            for ($i = 0; $i < count($tokens); $i++) {
			
                if ($tokens[$i]->getTokenName() === 'T_NAMESPACE') {
            
		    for ($j = $i + 1; $j < count($tokens); $j++) {
                    
		        if ($tokens[$j]->getTokenName() === 'T_NAME_QUALIFIED') {
						
                            $namespace = $tokens[$j]->text;
                        
			    break;
                        }
                    }
                }

                if ($tokens[$i]->getTokenName() === 'T_CLASS') {
				
                    for ($j = $i + 1; $j < count($tokens); $j++) {
					
                        if ($tokens[$j]->getTokenName() === 'T_WHITESPACE') {
						
                           continue;
                        }

                        if ($tokens[$j]->getTokenName() === 'T_STRING') {
                    
		            $classes[] = $namespace . '\\' . $tokens[$j]->text;
                    
			 } else {
						
                             break;
                         }
                     }
                 }
             }
		
             return $classes;
       }
  }
