<?

namespace Inspector\Project;

class TestIterableClass implements Iterator 
{
  
  private array $testArray = [1,2,3,4,5];

  public function __construct() {
  }

  public function rewind(): void
  {  
    return reset($this->testArray);
  }
  
  public function current(): mixed
  {  
    return current($this->testArray);
  }
  
  public function key(): mixed
  {  
    return key($this->testArray);
  }
  
  public function next(): void
  {  
    return next($this->testArray);
  }
  
  public function valid(): bool
  {	  
    return key($this->testArray) !== null;
  }

}

?>