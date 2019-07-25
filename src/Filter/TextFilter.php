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
    /** @var string */
    protected $placeholder;

    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param $value
     * @return bool
     */
    public function isValidValue($value): bool
    {
        return true;
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefaults([
                'type' => 'text',
                'template_html' => '@DataTables/filters/text.html.twig',
                'template_js' => '@DataTables/filters/text.js.twig',
                'placeholder' => null,
            ])
            ->setAllowedTypes('placeholder', ['null', 'string'])
        ;

        return $this;
    }
}
