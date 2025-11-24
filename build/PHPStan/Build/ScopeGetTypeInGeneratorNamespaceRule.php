<?php declare(strict_types = 1);

namespace PHPStan\Build;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;
use PHPUnit\Framework\TestCase;
use function in_array;
use function sprintf;
use function str_starts_with;

/**
 * @implements Rule<MethodCall>
 */
final class ScopeGetTypeInGeneratorNamespaceRule implements Rule
{

	public function getNodeType(): string
	{
		return MethodCall::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		$namespace = $scope->getNamespace();
		if ($namespace === null) {
			return [];
		}

		$invalidNamespace = 'PHPStan\\Analyser\\Generator';
		if (!str_starts_with($namespace . '\\', $invalidNamespace . '\\')) {
			return [];
		}

		if (!$node->name instanceof Node\Identifier) {
			return [];
		}

		$scopeType = new ObjectType(Scope::class);
		$calledOnType =  $scope->getType($node->var);
		if (!$scopeType->isSuperTypeOf($calledOnType)->yes()) {
			return [];
		}

		if ($scope->isInClass()) {
			$inClass = $scope->getClassReflection();
			if ($inClass->is(TestCase::class)) {
				return [];
			}
		}

		$inFunction = $scope->getFunction();
		if ($inFunction !== null && $inFunction->isDeprecated()->yes()) {
			return [];
		}

		$methodReflection = $scope->getMethodReflection($calledOnType, $node->name->toString());
		if ($methodReflection === null) {
			return [];
		}

		$message = sprintf(
			'Scope::%s() cannot be called in %s namespace.',
			$methodReflection->getName(),
			$invalidNamespace,
		);

		if (in_array($methodReflection->getName(), ['getType', 'getNativeType', 'getKeepVoidType'], true)) {
			return [
				RuleErrorBuilder::message($message)
					->identifier('phpstan.scopeGetType')
					->tip('Use yield new TypeExprRequest instead.')
					->build(),
			];
		}

		if (in_array($methodReflection->getName(), ['filterByTruthyValue', 'filterByFalseyValue'], true)) {
			return [
				RuleErrorBuilder::message($message)
					->identifier('phpstan.scopeFilter')
					->build(),
			];
		}

		return [];
	}

}
