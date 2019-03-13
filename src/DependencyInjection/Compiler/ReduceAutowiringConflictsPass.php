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

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Translation\Translator;

/**
 * Class ReduceAutowiringConflictsPass
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ReduceAutowiringConflictsPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $containerBuilder)
    {
        $symfonyTranslatorService = $containerBuilder->findDefinition('translator');

        // FrameworkBundle already adds an autowiring type for the interface TranslatorInterface -
        // this makes sure that anywhere expecting the Translator class itself will resolve to FrameworkBundle's too
        $symfonyTranslatorService->addAutowiringType(Translator::class);
    }
}
