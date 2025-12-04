<?php declare(strict_types = 1);

namespace PHPStan\Analyser\Generator;

/**
 * @template-covariant T
 */
final class RunInFiberResult
{

	/**
	 * @readonly
	 * @var T
	 */
	public mixed $value;

	/**
	 * @param T $value
	 */
	public function __construct(
		mixed $value,
	)
	{
		$this->value = $value;
	}

}
