<?php

namespace Inspector\Helpers;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class ArraysHelper
{    		
	public function __construct() {	
	}
	
	/**
	*
	* Retrieves all associative array files from src/Project folder
	*
	* @return array
	*
	*/	
	static function getArraysData(): array
	{
		$merged_arrays_data = [];
		
		$arraysData = [];
		
		$project_dirs = [];
		
		$project_dirs = $this->getDirectoriesList();
			
		if(!empty($project_dirs))  {
		
			foreach ($project_dirs as $dir_name) {
			
		           $arraysData[] = $this->getArraysDataFromDirectory($dir_name);	
			}
		}
		
		if(!empty($arraysData))  {
		
			foreach ($arraysData as $arr) {
			
			   $merged_arrays_data = array_merge($merged_arrays_data,$arr);		
			}
		}
		
		return $merged_arrays_data;	
	}	

	/**
	*
	* Retrieves all directories and subdirectories within the src/Project folder
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
	* retrieves all array files related data from directories and subdirectories
 	* within $directory
	*
	* @param string $directory
    *	
	* @return array
	*/
	private function getArraysDataFromDirectory(string $directory): array
        {
                $arraysData = [];
        
		foreach (new RecursiveIteratorIterator(
						new RecursiveDirectoryIterator(
							$directory, 
							RecursiveDirectoryIterator::SKIP_DOTS | RecursiveDirectoryIterator::CURRENT_AS_SELF				
						)
					) as $file
			) {
				$parts = [];			
					
				$parts = explode(".",$file);

				$extension = (is_array($parts) && count($parts) > 1) ? end($parts) : null;
					
				if ( (!is_null($extension)) && ((new SplFileInfo($file))->getExtension() === 'php') ) {
						
				    $dir_path = [];
						
				    $dir_path = pathinfo($directory);
																		
				    $trim_dir_name = ltrim($dir_path['dirname'],'/');
																
				     if (is_array($array = include  __DIR__ . '/../project' . "/$trim_dir_name/" . basename($file))) {
									
				         $arraysData['array_filepath'][] = '/project' . "/$trim_dir_name/" .  basename($file);
							
					 $arraysData['array_content'][] = include  __DIR__ . '/../project' . "/$trim_dir_name/" . basename($file);
				     }	
				 }
			  }
		
		          return $arraysData;
       }
}
