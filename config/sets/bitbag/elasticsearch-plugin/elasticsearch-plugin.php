<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Sylius\SyliusRector\Rector\Class_\AddInterfaceToClassExtendingTypeRector;
use Sylius\SyliusRector\Rector\Class_\AddTraitToClassExtendingTypeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfigurationComposerVersionBound(AddInterfaceToClassExtendingTypeRector::class, [
        'Sylius\Component\Core\Model\ProductVariant' => [
            'BitBag\SyliusElasticsearchPlugin\Model\ProductVariantInterface',
        ],
    ], 'bitbag/elasticsearch-plugin', '>=5.2 <6.0');

    $rectorConfig->ruleWithConfigurationComposerVersionBound(AddTraitToClassExtendingTypeRector::class, [
        'Sylius\Component\Core\Model\ProductVariant' => [
            'BitBag\SyliusElasticsearchPlugin\Model\ProductVariantTrait',
        ],
    ], 'bitbag/elasticsearch-plugin', '>=5.2 <6.0');
};
