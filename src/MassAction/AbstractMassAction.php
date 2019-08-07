<?php

declare(strict_types=1);

namespace Omines\DataTablesBundle\MassAction;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractMassAction
 * @package Omines\DataTablesBundle\Filter
 */
abstract class AbstractMassAction
{
    /**
     * @var array
     */
    protected $options;

    /**
     * AbstractFilter constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->options['name'];
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->options['label'];
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->options['action'];
    }

    /**
     * @param OptionsResolver $resolver
     * @return $this
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'name' => null,
                'label' => null,
                'action' => null
            ])
            ->setAllowedTypes('name', ['null', 'string'])
            ->setAllowedTypes('label', ['null', 'string'])
            ->setAllowedTypes('action', ['null', 'string'])
        ;

        return $this;
    }
}
