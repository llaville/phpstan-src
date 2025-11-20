<?php declare(strict_types = 1);

namespace GeneratorNodeScopeResolverTest;

use Closure;
use function PHPStan\Testing\assertNativeType;
use function PHPStan\Testing\assertType;

class Foo
{

	public function doFoo(int $i): ?string
	{
		return 'foo';
	}

	public function doImplicitArrayCreation(): void
	{
		$a['bla'] = 1;
		assertType('array{bla: 1}', $a);
	}

	/**
	 * @param int $a
	 * @param int $b
	 * @return void
	 */
	public function doPlus($a, $b, int $c, int $d): void
	{
		assertType('int', $a + $b);
		assertNativeType('(array|float|int)', $a + $b);
		assertType('2', 1 + 1);
		assertNativeType('2', 1 + 1);
		assertType('int', $c + $d);
		assertNativeType('int', $c + $d);
	}

}

function (): void {
	$foo = new Foo();
	assertType(Foo::class, $foo);
	assertType('string|null', $foo->doFoo(1));
	assertType($a = '1', (int) $a);
};

function (): void {
	assertType('array{foo: \'bar\'}', ['foo' => 'bar']);
	$a = [];
	assertType('array{}', $a);

};

function (): void {
	$a['bla'] = 1;
	assertType('array{bla: 1}', $a);
};

function (): void {
	$cb = fn () => 1;
	assertType('Closure(): 1', $cb);

	$cb = fn (string $s) => (int) $s;
	assertType('Closure(string): int', $cb);

	$cb = function () {
		return 1;
	};
	assertType('Closure(): 1', $cb);

	$a = 1;
	$cb = function () use (&$a) {
		return 1;
	};
	assertType('Closure(): 1', $cb);

	$cb = function (string $s) {
		return $s;
	};
	assertType('Closure(string): string', $cb);
};

function (): void {
	$a = 0;
	$cb = function () use (&$a): void {
		assertType('0|\'s\'', $a);
		$a = 's';
	};
	assertType('0|\'s\'', $a);
};

function (): void {
	$a = 0;
	$b = 0;
	$cb = function () use (&$a, $b): void {
		assertType('int<0, max>', $a);
		assertType('0', $b);
		$a = $a + 1;
		$b = 1;
	};
	assertType('int<0, max>', $a);
	assertType('0', $b);
};

function (): void {
	$a = 0;
	$cb = function () use (&$a): void {
		assertType('0|1', $a);
		$a = 1;
	};
	assertType('0|1', $a);
};

class FooWithStaticMethods
{

	public function doFoo(): void
	{
		assertType('GeneratorNodeScopeResolverTest\\FooWithStaticMethods', self::returnSelf());
		assertNativeType('GeneratorNodeScopeResolverTest\\FooWithStaticMethods', self::returnSelf());
		assertType('GeneratorNodeScopeResolverTest\\FooWithStaticMethods', self::returnPhpDocSelf());
		assertNativeType('mixed', self::returnPhpDocSelf());
	}

	public static function returnSelf(): self
	{

	}

	/**
	 * @return self
	 */
	public static function returnPhpDocSelf()
	{

	}

}

class ClosureFromCallableExtension
{

	/**
	 * @param callable(string, int=): bool $cb
	 */
	public function doFoo(callable $cb): void
	{
		assertType('callable(string, int=): bool', $cb);
		assertType('Closure(string, int=): bool', Closure::fromCallable($cb));
	}

}

/**
 * @template T
 */
class FooGeneric
{

	/**
	 * @param T $a
	 */
	public function __construct($a)
	{

	}

}

function (): void {
	//$foo = new FooGeneric(5);
	//assertType('GeneratorNodeScopeResolverTest\\FooGeneric<int>', $foo);
};
