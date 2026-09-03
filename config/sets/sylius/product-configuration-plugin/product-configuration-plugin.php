<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Sylius\SyliusRector\Rector\Class_\AddInterfaceToClassExtendingTypeRector;
use Sylius\SyliusRector\Rector\Class_\AddTraitToClassExtendingTypeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfigurationComposerVersionBound(AddInterfaceToClassExtendingTypeRector::class, [
        'Sylius\Component\Core\Model\Product' => ['Sylius\ProductCustomization\Entity\ProductInterface'],
    ], 'sylius/product-configurator-plugin', '>=0.1 <0.2');

    $rectorConfig->ruleWithConfigurationComposerVersionBound(AddTraitToClassExtendingTypeRector::class, [
        'Sylius\Component\Core\Model\OrderItem' => [
            'Sylius\ProductCustomization\Entity\Traits\OrderItemCustomizationsTrait',
        ],
        'Sylius\Component\Core\Model\Product' => [
            'Sylius\ProductCustomization\Entity\Traits\ProductCustomizationsTrait',
        ],
    ], 'sylius/product-configurator-plugin', '>=0.1 <0.2');
};
