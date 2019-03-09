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

use Combyna\Component\Framework\Bootstrap\BootstrapInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class CombynaExtension
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class CombynaExtension extends Extension
{
    const BOOTSTRAP_SERVICE_ID = 'combyna_bundle.bootstrap';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $containerBuilder)
    {
        $configuration = $this->getConfiguration($configs, $containerBuilder);
        $config = $this->processConfiguration($configuration, $configs);

        $bootstrapConfigServiceId = $config['bootstrap_config'];

        // Pass the consuming app's bootstrap config service to our bootstrap
        $bootstrapDefinition = $containerBuilder->getDefinition(self::BOOTSTRAP_SERVICE_ID);
        $bootstrapDefinition->replaceArgument(0, new Reference($bootstrapConfigServiceId));

        // Now fetch the bootstrap service, but only for use during the container build
        /** @var BootstrapInterface $transientBootstrap */
        $transientBootstrap = $containerBuilder->get(self::BOOTSTRAP_SERVICE_ID);

        // Merge the Combyna service container builder into the main application's,
        // so that the app ends up with only one service container
        $containerBuilder->merge($transientBootstrap->getContainerBuilder());
    }
}
