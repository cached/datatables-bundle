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

class ChoiceFilter extends AbstractFilter
{
    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->options['placeholder'];
    }

    /**
     * @return mixed
     */
    public function getChoices()
    {
        return $this->options['choices'];
    }

    /**
     * {@inheritdoc}
     */
    public function isValidValue($value): bool
    {
        return array_key_exists($value, $this->choices);
    }

    
    /**
     * @param OptionsResolver $resolver
     * @return $this
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefaults([
                'template_html' => '@DataTables/filters/select.html.twig',
                'placeholder' => null,
                'choices' => [],
            ])
            ->setAllowedTypes('placeholder', ['null', 'string'])
            ->setAllowedTypes('choices', ['array']);

        return $this;
    }
}
