<?php declare(strict_types = 1);

namespace PHPStan\Analyser;

use PhpParser\Node\Expr;
use SplObjectStorage;

final class ExpressionResultStorage
{

	/** @var SplObjectStorage<Expr, ExpressionResult> */
	private SplObjectStorage $results;

	public function __construct()
	{
		$this->results = new SplObjectStorage();
	}

	public function duplicate(): self
	{
		$new = new self();
		$new->results->addAll($this->results);
		return $new;
	}

	public function storeResult(Expr $expr, ExpressionResult $result): void
	{
		$this->results[$expr] = $result;
	}

	public function findResult(Expr $expr): ?ExpressionResult
	{
		return $this->results[$expr] ?? null;
	}

}
