<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Sylius\SyliusRector\Set\SyliusLiveOnePageCheckout;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->import(__DIR__ . '/../../../../config/config.php');
    $rectorConfig->sets([SyliusLiveOnePageCheckout::LIVE_ONE_PAGE_CHECKOUT_PLUGIN_01]);
};
