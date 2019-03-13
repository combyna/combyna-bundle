<?php

/**
 * Combyna Symfony bundle
 * Copyright (c) the Combyna project and contributors
 * https://github.com/combyna/combyna-bundle
 *
 * Released under the MIT license
 * https://github.com/combyna/combyna-bundle/raw/master/MIT-LICENSE.txt
 */

namespace Combyna\CombynaBundle;

use Combyna\CombynaBundle\DependencyInjection\Compiler\MergeCombynaIntoAppContainerPass;
use Combyna\CombynaBundle\DependencyInjection\Compiler\ReduceAutowiringConflictsPass;
use Combyna\CombynaBundle\DependencyInjection\Compiler\RegisterBootstrapConfigPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class CombynaBundle
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class CombynaBundle extends Bundle
{
    const CLIENT_BOOTSTRAP_SERVICE_ID = 'combyna_bundle.client_bootstrap';
    const SERVER_BOOTSTRAP_SERVICE_ID = 'combyna_bundle.server_bootstrap';

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $containerBuilder)
    {
        // Make sure the consuming app's bootstrap config is passed to our bootstrap services
        $containerBuilder->addCompilerPass(new RegisterBootstrapConfigPass());

        // Merge the Combyna Symfony DI container into the consuming app's container,
        // to allow injection of any services (and generally simplify things)
        $containerBuilder->addCompilerPass(new MergeCombynaIntoAppContainerPass());

        // As we merge Combyna's service container in above, there could be conflicts
        // as some services like Translator are already defined by Symfony'a FrameworkBundle
        $containerBuilder->addCompilerPass(new ReduceAutowiringConflictsPass());
    }
}
