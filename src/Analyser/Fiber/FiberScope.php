<?php declare(strict_types = 1);

namespace PHPStan\Analyser\Fiber;

use Fiber;
use PhpParser\Node\Expr;
use PHPStan\Analyser\ExpressionResult;
use PHPStan\Analyser\MutatingScope;
use PHPStan\Type\Type;

final class FiberScope extends MutatingScope
{

	/** @api */
	public function getType(Expr $node): Type
	{
		/** @var ExpressionResult $exprResult */
		$exprResult = Fiber::suspend(
			new ExpressionAnalysisRequest($node, $this),
		);

		return $exprResult->getBeforeScope()->toMutatingScope()->getType($node);
	}

	/** @api */
	public function getNativeType(Expr $expr): Type
	{
		/** @var ExpressionResult $exprResult */
		$exprResult = Fiber::suspend(
			new ExpressionAnalysisRequest($expr, $this),
		);

		return $exprResult->getBeforeScope()->toMutatingScope()->getNativeType($expr);
	}

	public function getKeepVoidType(Expr $node): Type
	{
		/** @var ExpressionResult $exprResult */
		$exprResult = Fiber::suspend(
			new ExpressionAnalysisRequest($node, $this),
		);

		return $exprResult->getBeforeScope()->toMutatingScope()->getKeepVoidType($node);
	}

}
