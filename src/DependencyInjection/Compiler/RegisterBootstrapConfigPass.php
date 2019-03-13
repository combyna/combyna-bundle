<?php

/**
 * Combyna Symfony bundle
 * Copyright (c) the Combyna project and contributors
 * https://github.com/combyna/combyna-bundle
 *
 * Released under the MIT license
 * https://github.com/combyna/combyna-bundle/raw/master/MIT-LICENSE.txt
 */

namespace Combyna\CombynaBundle\DependencyInjection\Compiler;

use Combyna\CombynaBundle\CombynaBundle;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterBootstrapConfigPass
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class RegisterBootstrapConfigPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $containerBuilder)
    {
        $bootstrapConfigServiceId = $containerBuilder->getParameter('combyna.bootstrap_config');

        // Pass the consuming app's bootstrap config service to our bootstraps
        $clientBootstrapDefinition = $containerBuilder->getDefinition(CombynaBundle::CLIENT_BOOTSTRAP_SERVICE_ID);
        $clientBootstrapDefinition->replaceArgument(0, new Reference($bootstrapConfigServiceId));
        $serverBootstrapDefinition = $containerBuilder->getDefinition(CombynaBundle::SERVER_BOOTSTRAP_SERVICE_ID);
        $serverBootstrapDefinition->replaceArgument(0, new Reference($bootstrapConfigServiceId));
    }
}
