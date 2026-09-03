<?php

declare(strict_types=1);

namespace Sylius\SyliusRector\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Attribute;
use PhpParser\Node\AttributeGroup;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Class_;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Sylius\SyliusRector\NodeManipulator\ClassInheritanceManipulator;
use Sylius\SyliusRector\Rector\Dto\Index;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Sylius\SyliusRector\Tests\Rector\Class_\AddIndexToClassExtendingType\AddIndexToClassExtendingTypeRectorTest
 */
final class AddIndexToClassExtendingTypeRector extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @var array<string, Index[]>
     */
    private array $configuration = [];

    public function __construct(
        private ClassInheritanceManipulator $classInheritanceManipulator,
    ) {
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Adds ORM\Index to classes extending the given type',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Payment as BasePayment;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_payment')]
class Payment extends BasePayment
{
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Payment as BasePayment;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_payment')]
#[ORM\Index(name: 'idx_payment_credit_approval_state', columns: ['credit_approval_state'])]
class Payment extends BasePayment
{
}
CODE_SAMPLE
                    ,
                ),
            ],
        );
    }

    public function getNodeTypes(): array
    {
        return [Class_::class];
    }

    public function configure(array $configuration): void
    {
        $this->configuration = $configuration;
    }

    /**
     * @param Class_ $node
     */
    public function refactor(Node $node): ?Node
    {
        $hasChanges = false;

        foreach ($this->configuration as $className => $indexes) {
            if (! $this->classInheritanceManipulator->isDerivative($node, $className)) {
                continue;
            }

            foreach ($indexes as $index) {
                if ($this->hasIndex($node, $index->name)) {
                    continue;
                }

                $this->addIndex($node, $index);
                $hasChanges = true;
            }
        }

        return $hasChanges ? $node : null;
    }

    private function hasIndex(Class_ $node, string $indexName): bool
    {
        foreach ($node->attrGroups as $attrGroup) {
            foreach ($attrGroup->attrs as $attr) {
                if (! $this->isIndexAttributeName($attr->name->toString())) {
                    continue;
                }

                if ($this->matchesIndexName($attr, $indexName)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function isIndexAttributeName(string $attributeName): bool
    {
        return in_array($attributeName, ['Doctrine\ORM\Mapping\Index', 'ORM\Index', 'Index'], true);
    }

    private function matchesIndexName(Attribute $attribute, string $indexName): bool
    {
        foreach ($attribute->args as $arg) {
            if (! $arg->name instanceof Identifier || $arg->name->toString() !== 'name') {
                continue;
            }

            return $arg->value instanceof String_ && $arg->value->value === $indexName;
        }

        return false;
    }

    private function addIndex(Class_ $node, Index $index): void
    {
        $columnItems = [];
        foreach ($index->columns as $column) {
            $columnItems[] = new ArrayItem(new String_($column));
        }

        $attribute = new Attribute(
            new FullyQualified('Doctrine\ORM\Mapping\Index'),
            [
                new Arg(new String_($index->name), false, false, [], new Identifier('name')),
                new Arg(
                    new Array_($columnItems, [
                        'kind' => Array_::KIND_SHORT,
                    ]),
                    false,
                    false,
                    [],
                    new Identifier('columns'),
                ),
            ],
        );

        $node->attrGroups[] = new AttributeGroup([$attribute]);
    }
}
