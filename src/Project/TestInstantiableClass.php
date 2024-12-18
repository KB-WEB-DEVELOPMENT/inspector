<?

namespace Inspector\Project;

#[TestAttribute]
class TestInstantiableClass
{
	const TEST_CONSTANT = 'constant value';
	
	public string $testProperty = 'test property value';

	use TestOriginalTrait;

	use TestTraitForAlias1, TestTraitForAlias2 {
        TestTraitForAlias1::testTraitMethod as aliasedTestTraitMethod;
     }

    public function __construct() {
	}
	
	public function testMethod(string $testParameter='test method parameter default value'): array
	{
		return [];
	}

	public function __destruct() {
	}
}

?>