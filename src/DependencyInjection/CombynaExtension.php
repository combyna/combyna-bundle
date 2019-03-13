<?php

/**
 * Combyna Symfony bundle
 * Copyright (c) the Combyna project and contributors
 * https://github.com/combyna/combyna-bundle
 *
 * Released under the MIT license
 * https://github.com/combyna/combyna-bundle/raw/master/MIT-LICENSE.txt
 */

namespace Combyna\CombynaBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\DirectoryLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class CombynaExtension
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class CombynaExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $containerBuilder)
    {
        $fileLocator = new FileLocator(__DIR__ . '/../Resources/config');
        $loader = new DirectoryLoader($containerBuilder, $fileLocator);
        $loader->setResolver(new LoaderResolver([
            new YamlFileLoader($containerBuilder, $fileLocator),
            $loader
        ]));
        $loader->load('services/');

        $configuration = $this->getConfiguration($configs, $containerBuilder);
        $config = $this->processConfiguration($configuration, $configs);

        $bootstrapConfigServiceId = $config['bootstrap_config'];

        // Pass the bootstrap config service ID to the RegisterBootstrapConfigPass compiler pass
        $containerBuilder->setParameter('combyna.bootstrap_config', $bootstrapConfigServiceId);
    }
}
