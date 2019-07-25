<?php

declare(strict_types=1);

namespace Omines\DataTablesBundle\Filter;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ChoiceFilter
 * @package Omines\DataTablesBundle\Filter
 */
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
     * @return $this|AbstractFilter
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
