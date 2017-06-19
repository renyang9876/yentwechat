<?php

namespace YEntWeChat\Foundation\ServiceProviders;

use YEntWeChat\Menu\Menu;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class MenuServiceProvider.
 */
class MenuServiceProvider implements ServiceProviderInterface
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
        $pimple['menu'] = function ($pimple) {
            return new Menu($pimple['access_token']);
        };
    }
}
