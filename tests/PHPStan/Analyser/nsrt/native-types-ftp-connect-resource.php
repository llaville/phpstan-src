<?php // lint < 8.1

namespace NativeTypesFtpConnectResource;

use function PHPStan\Testing\assertNativeType;
use function PHPStan\Testing\assertType;

class Foo
{

	public function doFoo(): void
	{
		$f = ftp_connect('example.com');
		assertType('resource|false', $f);
		assertNativeType('resource|false', $f); // could be mixed
	}

}
