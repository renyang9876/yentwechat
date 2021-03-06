<?php

namespace YEntWeChat\Foundation\ServiceProviders;

use YEntWeChat\Fundamental\API;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class FundamentalServiceProvider.
 */
class FundamentalServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $pimple)
    {
        $pimple['fundamental.api'] = function ($pimple) {
            return new API($pimple['access_token']);
        };
    }
}
