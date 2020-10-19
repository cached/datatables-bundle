<?php

declare(strict_types=1);

namespace Omines\DataTablesBundle\Traits;

use Omines\DataTablesBundle\Exception\InvalidArgumentException;
use Omines\DataTablesBundle\Filter\AbstractFilter;

/**
 * Trait FilterTrait
 * @package Omines\DataTablesBundle\Traits
 */
trait FilterTrait
{
    /**
     * @var AbstractFilter[]
     */
    protected $filters = [];

    /**
     * @var array<string, AbstractFilter>
     */
    protected $filtersByName = [];

    /**
     * @param AbstractFilter $filter
     * @return $this
     */
    public function addFilter(AbstractFilter $filter)
    {
        $name = $filter->getName();

        if (isset($this->filtersByName[$name])) {
            throw new InvalidArgumentException(sprintf('There already is a filter with name "%s"', $name));
        }

        $this->filters[] = $filter;
        $this->filtersByName[$name] = $filter;

        return $this;
    }

    /**
     * @param string $name
     * @return AbstractFilter
     */
    public function getFilterByName(string $name): AbstractFilter
    {
        if (!isset($this->filtersByName[$name])) {
            throw new InvalidArgumentException(sprintf('There is no filter named "%s', $name));
        }

        return $this->filtersByName[$name];
    }

    /**
     * @return AbstractFilter[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @return bool
     */
    public function hasFilters()
    {
        return (bool)count($this->filters);
    }
}