<?php

/**
 * Combyna Symfony bundle
 * Copyright (c) the Combyna project and contributors
 * https://github.com/combyna/combyna-bundle
 *
 * Released under the MIT license
 * https://github.com/combyna/combyna-bundle/raw/master/MIT-LICENSE.txt
 */

namespace Combyna\CombynaBundle\Command;

use Combyna\Component\Framework\Bootstrap\BootstrapInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ClientCacheWarmupCommand
 *
 * Warms the client originator cache. Used by front-end builds, as we need to make sure
 * that the client (browser) -side container and eg. expression parser are built
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ClientCacheWarmupCommand extends Command
{
    /**
     * @var BootstrapInterface
     */
    private $bootstrap;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @var string
     */
    private $environment;

    /**
     * @param BootstrapInterface $bootstrap
     * @param string $environment
     * @param bool $debug
     */
    public function __construct(BootstrapInterface $bootstrap, $environment = 'dev', $debug = false)
    {
        parent::__construct();

        $this->bootstrap = $bootstrap;
        $this->debug = $debug;
        $this->environment = $environment;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('combyna:cache:warmup')
            ->setDescription('Warms up the cache for a client build of a Combyna app')
            ->setHelp(<<<'EOF'
The <info>%command.name%</info> command warms up the cache.

Before running this command, the cache may or may not be empty.

EOF
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->comment(
            sprintf(
                'Warming up the Combyna client cache for the <info>%s</info> environment with debug <info>%s</info>',
                $this->environment,
                var_export($this->debug, true)
            )
        );

        $this->bootstrap->getContainer(); // Create the standalone Combyna container
        $this->bootstrap->warmUp();

        $io->success(
            sprintf(
                'Combyna client cache for the "%s" environment (debug=%s) was successfully warmed.',
                $this->environment,
                var_export($this->debug, true)
            )
        );
    }
}
