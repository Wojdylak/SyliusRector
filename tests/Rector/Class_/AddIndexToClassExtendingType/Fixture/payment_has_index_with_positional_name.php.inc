<?php

declare(strict_types=1);

namespace App\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Payment as BasePayment;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_payment')]
#[ORM\Index('idx_payment_credit_approval_state', ['credit_approval_state'])]
class Payment extends BasePayment
{
}

?>
