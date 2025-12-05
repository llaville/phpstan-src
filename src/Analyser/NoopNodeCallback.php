<?php declare(strict_types = 1);

namespace PHPStan\Analyser;

final class NoopNodeCallback
{

	public function __invoke(): void
	{
		// noop
	}

}
