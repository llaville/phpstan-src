<?php declare(strict_types = 1);

namespace PHPStan\Analyser;

use PhpParser\Node;

final class NoopNodeCallback implements ShallowNodeCallback
{

	public function __invoke(Node $node, Scope $scope): void
	{
		// noop
	}

}
