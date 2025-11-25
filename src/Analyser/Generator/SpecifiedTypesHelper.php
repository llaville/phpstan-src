<?php declare(strict_types = 1);

namespace PHPStan\Analyser\Generator;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Instanceof_;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\DependencyInjection\AutowiredService;
use PHPStan\Node\Expr\AlwaysRememberedExpr;
use PHPStan\Node\Printer\ExprPrinter;
use PHPStan\Type\StaticTypeFactory;
use PHPStan\Type\Type;

#[AutowiredService]
final class SpecifiedTypesHelper
{

	public function __construct(
		private ExprPrinter $exprPrinter,
	)
	{
	}

	public function createDefaultSpecifiedTruthyTypes(Expr $expr): SpecifiedTypes
	{
		$type = StaticTypeFactory::falsey();
		return $this->create($expr, $type, TypeSpecifierContext::createFalse())->setRootExpr($expr);
	}

	public function createDefaultSpecifiedFalseyTypes(Expr $expr): SpecifiedTypes
	{
		$type = StaticTypeFactory::truthy();
		return $this->create($expr, $type, TypeSpecifierContext::createFalse())->setRootExpr($expr);
	}

	private function create(
		Expr $expr,
		Type $type,
		TypeSpecifierContext $context,
	): SpecifiedTypes
	{
		if ($expr instanceof Instanceof_ || $expr instanceof Expr\List_) {
			return (new SpecifiedTypes([], []))->setRootExpr($expr);
		}

		$specifiedExprs = [$expr];
		if ($expr instanceof AlwaysRememberedExpr) {
			$specifiedExprs[] = $expr->expr;
		}

		$types = null;

		foreach ($specifiedExprs as $specifiedExpr) {
			$newTypes = $this->createForExpr($specifiedExpr, $type, $context);

			if ($types === null) {
				$types = $newTypes;
			} else {
				$types = $types->unionWith($newTypes);
			}
		}

		return $types;
	}

	private function createForExpr(
		Expr $expr,
		Type $type,
		TypeSpecifierContext $context,
	): SpecifiedTypes
	{
		$sureTypes = [];
		$sureNotTypes = [];
		$exprString = $this->exprPrinter->printExpr($expr);
		if ($context->false()) {
			$sureNotTypes[$exprString] = [$expr, $type];
		} elseif ($context->true()) {
			$sureTypes[$exprString] = [$expr, $type];
		}

		return new SpecifiedTypes($sureTypes, $sureNotTypes);
	}

}
