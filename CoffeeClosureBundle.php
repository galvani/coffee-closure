<?php

namespace Galvani\CoffeeClosureBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CoffeeClosureBundle extends Bundle
{
	public function load(array $configs, ContainerBuilder $container)
    {

        $loader = new YmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('coffee.yml');
    }

    public function getAlias()
    {
        return 'galvani_coffeeclosure';
    }
}
