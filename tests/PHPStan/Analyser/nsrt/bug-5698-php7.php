<?php // lint < 8.0

namespace Bug5698;

use function PHPStan\Testing\assertNativeType;
use function PHPStan\Testing\assertType;

class FooPHP7
{

	function foo(int ...$foo): void {
		assertType('list<int>', $foo);
		assertNativeType('list<int>', $foo);
	}

}
