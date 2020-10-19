<?php

declare(strict_types=1);

namespace Omines\DataTablesBundle\Traits;

use Omines\DataTablesBundle\Exception\InvalidArgumentException;
use Omines\DataTablesBundle\Filter\AbstractFilter;
use Omines\DataTablesBundle\MassAction\AbstractMassAction;

/**
 * Trait MassActionTrait
 * @package Omines\DataTablesBundle\Traits
 */
trait MassActionTrait
{
    /**
     * @var AbstractMassAction[]
     */
    protected $massActions = [];

    /**
     * @var array<string, AbstractMassAction>
     */
    protected $massActionsByName = [];

    /**
     * @param AbstractMassAction $massAction
     * @return $this
     */
    public function addMassAction(AbstractMassAction $massAction)
    {
        $name = $massAction->getName();

        if (isset($this->massActionsByName[$name])) {
            throw new InvalidArgumentException(sprintf('There already is a mass action with name "%s"', $name));
        }

        $this->massActions[] = $massAction;
        $this->massActionsByName[$name] = $massAction;

        return $this;
    }

    /**
     * @param string $name
     * @return AbstractMassAction
     */
    public function getMassActionByName(string $name): AbstractMassAction
    {
        if (!isset($this->massActionsByName[$name])) {
            throw new InvalidArgumentException(sprintf('There is no filter named "%s', $name));
        }

        return $this->massActionsByName[$name];
    }

    /**
     * @return array
     */
    public function getMassActions(): array
    {
        return $this->massActions;
    }

    /**
     * @return bool
     */
    public function hasMassActions()
    {
        return (bool)count($this->massActions);
    }
}