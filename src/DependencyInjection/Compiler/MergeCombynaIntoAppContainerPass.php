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
use Combyna\Component\Framework\Bootstrap\BootstrapInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class MergeCombynaIntoAppContainerPass
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class MergeCombynaIntoAppContainerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $containerBuilder)
    {
        // Now fetch the bootstrap service, but only for use during the container build
        /** @var BootstrapInterface $transientBootstrap */
        $transientBootstrap = $containerBuilder->get(CombynaBundle::SERVER_BOOTSTRAP_SERVICE_ID);

        $combynaContainerBuilder = $transientBootstrap->getContainerBuilder();

        // Merge the Combyna service container builder into the main application's,
        // so that the app ends up with only one service container
        $containerBuilder->merge($combynaContainerBuilder);
    }
}
