<?php

namespace Galvani\CoffeeClosureBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CoffeeClosureExtension extends Extension {

	/**
	 *
	 * @var array
	 */
	protected $config;

	/**
	 * {@inheritDoc}
	 */
	public function load(array $configs, ContainerBuilder $container) {
		$config = array();
		foreach ($configs as $subConfig) {
			$config = array_merge($config, $subConfig);
		}
		$this->config = $config;
	}

	public function getAlias() {
		return 'coffee_closure';
	}

	public function getXsdValidationBasePath() {
		return __DIR__ . '/../Resources/config/';
	}

}
