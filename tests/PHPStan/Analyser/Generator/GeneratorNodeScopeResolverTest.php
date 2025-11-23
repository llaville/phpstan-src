<?php declare(strict_types = 1);

namespace PHPStan\Analyser\Generator;

use PHPStan\Analyser\Generator\NodeHandler\VarAnnotationHelper;
use PHPStan\Node\Printer\ExprPrinter;
use PHPStan\Testing\TypeInferenceTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RequiresPhp;

#[RequiresPhp('>= 8.1')]
class GeneratorNodeScopeResolverTest extends TypeInferenceTestCase
{

	public static function dataFileAsserts(): iterable
	{
		yield from self::gatherAssertTypes(__DIR__ . '/data/gnsr.php');
	}

	/**
	 * @param mixed ...$args
	 */
	#[DataProvider('dataFileAsserts')]
	public function testFileAsserts(
		string $assertType,
		string $file,
		...$args,
	): void
	{
		$this->assertFileAsserts($assertType, $file, ...$args);
	}

	protected static function createNodeScopeResolver(): GeneratorNodeScopeResolver
	{
		return new GeneratorNodeScopeResolver(
			self::getContainer()->getByType(ExprPrinter::class),
			self::getContainer()->getByType(VarAnnotationHelper::class),
			self::getContainer(),
		);
	}

	public static function getAdditionalConfigFiles(): array
	{
		return [
			__DIR__ . '/../../../../conf/bleedingEdge.neon',
		];
	}

}
