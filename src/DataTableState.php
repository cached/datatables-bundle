<?php

/*
 * Symfony DataTables Bundle
 * (c) Omines Internetbureau B.V. - https://omines.nl/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Omines\DataTablesBundle;

use Omines\DataTablesBundle\Column\AbstractColumn;
use Omines\DataTablesBundle\Filter\AbstractFilter;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * DataTableState.
 *
 * @author Robbert Beesems <robbert.beesems@omines.com>
 */
class DataTableState
{
    /**
     * @var DataTable
     */
    private $dataTable;

    /**
     * @var int
     */
    private $draw = 0;

    /**
     * @var int
     */
    private $start = 0;

    /**
     * @var int
     */
    private $length = -1;

    /**
     * @var string
     */
    private $globalSearch = '';

    /**
     * @var array
     */
    private $filters = [];

    /**
     * @var array
     */
    private $orderBy = [];

    /**
     * @var bool
     */
    private $isInitial = false;

    /**
     * @var bool
     */
    private $isCallback = false;

    /**
     * DataTableState constructor.
     *
     * @param DataTable $dataTable
     */
    public function __construct(DataTable $dataTable)
    {
        $this->dataTable = $dataTable;
    }

    /**
     * Constructs a state based on the default options.
     *
     * @param DataTable $dataTable
     * @return DataTableState
     */
    public static function fromDefaults(DataTable $dataTable)
    {
        $state = new self($dataTable);
        $state->start = (int) $dataTable->getOption('start');
        $state->length = (int) $dataTable->getOption('pageLength');

        foreach ($dataTable->getOption('order') as $order) {
            $state->addOrderBy($dataTable->getColumn($order[0]), $order[1]);
        }

        return $state;
    }

    /**
     * Loads datatables state from a parameter bag on top of any existing settings.
     *
     * @param ParameterBag $parameters
     * @param array $filters
     */
    public function applyParameters(ParameterBag $parameters, array $filters = [])
    {
        $this->draw = $parameters->getInt('draw');
        $this->isCallback = true;
        $this->isInitial = $parameters->getBoolean('_init', false);

        $this->start = (int) $parameters->get('start', $this->start);
        $this->length = (int) $parameters->get('length', $this->length);

        $search = $parameters->get('search', []);
        $this->setGlobalSearch($search['value'] ?? $this->globalSearch);

        $this->handleOrderBy($parameters);
        $this->handleFilter($filters);
    }

    /**
     * @param ParameterBag $parameters
     */
    private function handleOrderBy(ParameterBag $parameters)
    {
        if ($parameters->has('order')) {
            $this->orderBy = [];
            foreach ($parameters->get('order', []) as $order) {
                $column = $this->getDataTable()->getColumn((int) $order['column']);
                $this->addOrderBy($column, $order['dir'] ?? DataTable::SORT_ASCENDING);
            }
        }
    }

    /**
     * @param $filters
     */
    private function handleFilter($filters)
    {
        foreach ($this->dataTable->getFilters() as $filter) {
            if (isset($filters[$filter->getName()])) {
                $value = $filters[$filter->getName()];
                
                $this->setFilter($filter, $value);
            }
        }
    }

    /**
     * @return bool
     */
    public function isInitial(): bool
    {
        return $this->isInitial;
    }

    /**
     * @return bool
     */
    public function isCallback(): bool
    {
        return $this->isCallback;
    }

    /**
     * @return DataTable
     */
    public function getDataTable(): DataTable
    {
        return $this->dataTable;
    }

    /**
     * @return int
     */
    public function getDraw(): int
    {
        return $this->draw;
    }

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @param int $start
     * @return $this
     */
    public function setStart(int $start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @param int $length
     * @return $this
     */
    public function setLength(int $length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @return string
     */
    public function getGlobalSearch(): string
    {
        return $this->globalSearch;
    }

    /**
     * @param string $globalSearch
     * @return $this
     */
    public function setGlobalSearch(string $globalSearch)
    {
        $this->globalSearch = $globalSearch;

        return $this;
    }

    /**
     * @param AbstractColumn $column
     * @param string $direction
     * @return $this
     */
    public function addOrderBy(AbstractColumn $column, string $direction = DataTable::SORT_ASCENDING)
    {
        $this->orderBy[] = [$column, $direction];

        return $this;
    }

    /**
     * @return array
     */
    public function getOrderBy(): array
    {
        return $this->orderBy;
    }

    /**
     * @param array $orderBy
     * @return $this
     */
    public function setOrderBy(array $orderBy = []): self
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @param AbstractFilter $filter
     * @param string $search
     * @return $this
     */
    public function setFilter(AbstractFilter $filter, string $search)
    {
        $this->filters[$filter->getName()] = ['filter' => $filter, 'search' => $search];
        
        return $this;
    }
}
