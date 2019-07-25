<?php

/*
 * Symfony DataTables Bundle
 * (c) Omines Internetbureau B.V. - https://omines.nl/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Omines\DataTablesBundle\Filter;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TextFilter
 * @package Omines\DataTablesBundle\Filter
 */
class TextFilter extends AbstractFilter
{
    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->options['placeholder'];
    }

    /**
     * @param OptionsResolver $resolver
     * @return $this|AbstractFilter
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefaults([
                'type' => 'text',
                'template_html' => '@DataTables/filters/text.html.twig',
                'placeholder' => null,
            ])
            ->setAllowedTypes('placeholder', ['null', 'string'])
        ;

        return $this;
    }
}
