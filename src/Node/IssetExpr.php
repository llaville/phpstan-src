<?php declare(strict_types = 1);

namespace PHPStan\Node;

use PhpParser\Node\Expr;

final class IssetExpr extends Expr implements VirtualNode
{

	public function __construct(
		private Expr $expr,
	)
	{
		parent::__construct([]);
	}

	public function getExpr(): Expr
	{
		return $this->expr;
	}

	public function getType(): string
	{
		return 'PHPStan_Node_IssetExpr';
	}

	/**
	 * @return string[]
	 */
	public function getSubNodeNames(): array
	{
		return [];
	}

}
