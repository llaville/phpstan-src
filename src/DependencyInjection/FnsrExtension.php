<?php declare(strict_types = 1);

namespace PHPStan\DependencyInjection;

use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\ServiceDefinition;
use Override;
use PHPStan\Analyser\Analyser;
use PHPStan\Analyser\Fiber\FiberNodeScopeResolver;
use PHPStan\Analyser\FileAnalyser;
use PHPStan\ShouldNotHappenException;
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
		$analyserDef = $builder->getDefinitionByType(Analyser::class);
		if (!$analyserDef instanceof ServiceDefinition) {
			throw new ShouldNotHappenException();
		}
		$analyserDef->setArgument('nodeScopeResolver', '@' . FiberNodeScopeResolver::class);

		$fileAnalyserDef = $builder->getDefinitionByType(FileAnalyser::class);
		if (!$fileAnalyserDef instanceof ServiceDefinition) {
			throw new ShouldNotHappenException();
		}
		$fileAnalyserDef->setArgument('nodeScopeResolver', '@' . FiberNodeScopeResolver::class);
	}

}
