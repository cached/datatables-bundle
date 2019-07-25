<?php

declare(strict_types=1);

namespace Omines\DataTablesBundle\Filter;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DateFilter
 * @package Omines\DataTablesBundle\Filter
 */
class DateFilter extends TextFilter
{
    /**
     * @param OptionsResolver $resolver
     * @return $this|AbstractFilter|TextFilter
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefaults([
                'template_html' => '@DataTables/filters/date.html.twig',
                'operator' => '=',
                'rightExpr' => null
            ])
        ;

        return $this;
    }
}
