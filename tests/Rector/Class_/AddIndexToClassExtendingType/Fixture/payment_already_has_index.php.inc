<?php

declare(strict_types=1);

namespace App\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Sylius\Component\Core\Model\Payment as BasePayment;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_payment')]
#[Index(name: 'idx_payment_credit_approval_state', columns: ['credit_approval_state'])]
class Payment extends BasePayment
{
}

?>
