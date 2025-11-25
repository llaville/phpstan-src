<?php declare(strict_types = 1);

namespace PHPStan\Analyser\Generator;

use PHPStan\Analyser\ImpurePoint;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Type\Type;

final class ExprAnalysisResult
{

	public readonly Type $keepVoidType;

	/**
	 * @param InternalThrowPoint[] $throwPoints
	 * @param ImpurePoint[] $impurePoints
	 */
	public function __construct(
		public readonly Type $type,
		public readonly Type $nativeType,
		public readonly GeneratorScope $scope,
		public readonly bool $hasYield,
		public readonly bool $isAlwaysTerminating,
		public readonly array $throwPoints,
		public readonly array $impurePoints,
		public readonly SpecifiedTypes $specifiedTruthyTypes,
		public readonly SpecifiedTypes $specifiedFalseyTypes,
		public readonly SpecifiedTypes $specifiedNullTypes,
		?Type $keepVoidType = null,
	)
	{
		$this->keepVoidType = $keepVoidType ?? $type;
	}

}
