<?php

namespace YEntWeChat\Foundation\ServiceProviders;

use YEntWeChat\Soter\Soter;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class SoterServiceProvider.
 */
class SoterServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['soter'] = function ($pimple) {
            return new Soter($pimple['access_token']);
        };
    }
}
