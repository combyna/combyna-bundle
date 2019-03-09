<?php

/**
 * Combyna Symfony bundle
 * Copyright (c) the Combyna project and contributors
 * https://github.com/combyna/combyna-bundle
 *
 * Released under the MIT license
 * https://github.com/combyna/combyna-bundle/raw/master/MIT-LICENSE.txt
 */

namespace Combyna\CombynaBundle\CacheWarmer;

use Combyna\Component\Framework\Bootstrap\BootstrapInterface;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

/**
 * Class CombynaCacheWarmer
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class CombynaCacheWarmer implements CacheWarmerInterface
{
    /**
     * @var BootstrapInterface
     */
    private $bootstrap;

    /**
     * @param BootstrapInterface $bootstrap
     */
    public function __construct(BootstrapInterface $bootstrap)
    {
        $this->bootstrap = $bootstrap;
    }

    /**
     * {@inheritdoc}
     */
    public function isOptional()
    {
        return false; // We don't want to lazily generate some Combyna cache, such as the expression parser
    }

    /**
     * {@inheritdoc}
     */
    public function warmUp($cacheDir)
    {
        $this->bootstrap->warmUp();
    }
}
