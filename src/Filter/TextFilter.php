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

class TextFilter extends AbstractFilter
{
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefaults([
                'type' => 'text',
                'placeholder' => null,
                'template_html' => '@DataTables/filters/text.html.twig',
                'operator' => 'LIKE',
                'rightExpr' => function($value) {
                    return '%' . $value . '%';
                }
            ])
            ->setAllowedTypes('placeholder', ['null', 'string']);

        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->options['placeholder'];
    }

    /**
     * @param $value
     * @return bool
     */
    public function isValidValue($value): bool
    {
        return true;
    }
}
