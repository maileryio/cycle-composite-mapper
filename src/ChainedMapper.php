<?php

declare(strict_types=1);

/**
 * Mapper for Cycle ORM
 * @link      https://github.com/maileryio/cycle-mapper
 * @package   Mailery\Cycle\Mapper
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Cycle\Mapper;

use Cycle\ORM\Command\CommandInterface;
use Cycle\ORM\Command\ContextCarrierInterface;
use Cycle\ORM\Heap\Node;
use Cycle\ORM\Heap\State;
use Cycle\ORM\Mapper\Mapper;

class ChainedMapper extends Mapper
{
    /**
     * @param object $entity
     * @param Node $node
     * @param State $state
     * @return ContextCarrierInterface
     */
    public function queueCreate($entity, Node $node, State $state): ContextCarrierInterface
    {
        return $this->getChainItemList()->queueCreate(
            $entity,
            $node,
            $state,
            parent::queueCreate($entity, $node, $state)
        );
    }

    /**
     * @param object $entity
     * @param Node $node
     * @param State $state
     * @return ContextCarrierInterface
     */
    public function queueUpdate($entity, Node $node, State $state): ContextCarrierInterface
    {
        return $this->getChainItemList()->queueUpdate(
            $entity,
            $node,
            $state,
            parent::queueUpdate($entity, $node, $state)
        );
    }

    /**
     * @param object $entity
     * @param Node $node
     * @param State $state
     * @return CommandInterface
     */
    public function queueDelete($entity, Node $node, State $state): CommandInterface
    {
        return $this->getChainItemList()->queueDelete(
            $entity,
            $node,
            $state,
            parent::queueDelete($entity, $node, $state)
        );
    }

    /**
     * @return ChainItemList
     */
    protected function getChainItemList(): ChainItemList
    {
        return new ChainItemList();
    }
}
