<?php declare(strict_types = 1);

namespace PHPStan\Analyser;

use Fiber;
use PhpParser\Node\Expr;
use PHPStan\Analyser\Fiber\ExpressionAnalysisRequest;
use SplObjectStorage;

final class ExpressionResultStorage
{

	/** @var SplObjectStorage<Expr, ExpressionResult> */
	private SplObjectStorage $results;

	/** @var array<array{fiber: Fiber<mixed, ExpressionResult, null, ExpressionAnalysisRequest>, request: ExpressionAnalysisRequest}> */
	public array $pendingFibers = [];

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
