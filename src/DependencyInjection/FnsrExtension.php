<?php declare(strict_types = 1);

namespace PHPStan\DependencyInjection;

use Nette\DI\CompilerExtension;
use Override;
use PHPStan\Analyser\Fiber\FiberNodeScopeResolver;
use PHPStan\Analyser\NodeScopeResolver;
use function getenv;

final class FnsrExtension extends CompilerExtension
{

	#[Override]
	public function beforeCompile()
	{
		$enable = getenv('PHPSTAN_FNSR');
		if ($enable !== '1') {
			return;
		}

		$builder = $this->getContainerBuilder();
		$nodeScopeResolverDef = $builder->getDefinitionByType(NodeScopeResolver::class);
		$nodeScopeResolverDef->setAutowired(false);

		$fiberNodeScopeResolverDef = $builder->getDefinitionByType(FiberNodeScopeResolver::class);
		$fiberNodeScopeResolverDef->setAutowired([NodeScopeResolver::class, FiberNodeScopeResolver::class]);
	}

}
