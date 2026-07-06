<?php

namespace Sylius\SyliusRector\Tests\Set\LiveOnePageCheckoutPlugin\Fixture;

use Sylius\Component\Core\Model\Channel as BaseChannel;

class Channel extends BaseChannel
{
}

?>
-----
<?php

namespace Sylius\SyliusRector\Tests\Set\LiveOnePageCheckoutPlugin\Fixture;

use Sylius\Component\Core\Model\Channel as BaseChannel;
use Sylius\LiveOnePageCheckoutPlugin\Entity\ChannelInterface;
use Sylius\LiveOnePageCheckoutPlugin\Entity\ChannelOnePageCheckoutAwareTrait;

class Channel extends BaseChannel implements ChannelInterface
{
    use ChannelOnePageCheckoutAwareTrait;
}

?>
