<?php

namespace ScopeGetTypeGeneratorNs {

	use PHPStan\Analyser\Scope;

	class Foo
	{

		public function doFoo(Scope $scope): void
		{
			$scope->getType();
		}

	}
}

namespace PHPStan\Analyser\Generator {

	use PHPStan\Analyser\Scope;

	class Foo
	{

		public function doFoo(Scope $scope): void
		{
			$scope->getType();
		}

	}
}

namespace PHPStan\Analyser\Generator\ExprHandler {

	use PHPStan\Analyser\Generator\GeneratorScope;
	use PHPStan\Analyser\Scope;

	class Foo
	{

		public function doFoo(Scope $scope): void
		{
			$scope->getType();
		}

		public function doBar(GeneratorScope $scope): void
		{
			$scope->getType();
			$scope->getNativeType();
			$scope->getKeepVoidType();
		}

	}

	class Bar
	{

		public function doFoo(Scope $scope): void
		{
			$scope->filterByTruthyValue();
			$scope->filterByFalseyValue();
		}

		public function doBar(GeneratorScope $scope): void
		{
			$scope->filterByTruthyValue();
			$scope->filterByFalseyValue();
		}

	}
}
