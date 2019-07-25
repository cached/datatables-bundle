<?php

declare(strict_types=1);

namespace Omines\DataTablesBundle\Filter;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DateRangeFilter
 * @package Omines\DataTablesBundle\Filter
 */
class DateRangeFilter extends DateFilter
{
    /**
     * @param OptionsResolver $resolver
     * @return $this|DateFilter
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefaults([
                'template_html' => '@DataTables/filters/date_range.html.twig',
                'operator' => '=',
                'rightExpr' => null
            ])
        ;

        return $this;
    }
}
