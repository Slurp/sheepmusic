<?php

namespace AppBundle\Features\Context;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 *
 */
class FeatureContext extends MinkContext implements KernelAwareContext
{
    /**
     * @var
     */
    private $kernel;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        var_dump($parameters);
    }

    /**
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return mixed
     */
    protected function getContainer()
    {
        return $this->kernel->getContainer();
    }
}