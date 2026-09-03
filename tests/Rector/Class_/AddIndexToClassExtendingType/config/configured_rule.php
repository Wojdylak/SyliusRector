<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Sylius\SyliusRector\Rector\Class_\AddIndexToClassExtendingTypeRector;
use Sylius\SyliusRector\Rector\Dto\Index;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(AddIndexToClassExtendingTypeRector::class, [
        'Sylius\Component\Core\Model\Payment' => [
            new Index('idx_payment_credit_approval_state', ['credit_approval_state']),
        ],
    ]);
};
