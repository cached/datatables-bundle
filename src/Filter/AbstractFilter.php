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

abstract class AbstractFilter
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string 
     */
    protected $template_html;

    /** 
     * @var string 
     */
    protected $template_js;

    /** 
     * @var string 
     */
    protected $operator;

    public function __construct(array $options)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        foreach ($resolver->resolve($options) as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getTemplateHtml()
    {
        return $this->template_html;
    }

    /**
     * @return string
     */
    public function getTemplateJs()
    {
        return $this->template_js;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @return callable|null
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    abstract public function isValidValue($value): bool;

    
    /**
     * @param OptionsResolver $resolver
     * @return $this
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'type' => null,
                'name' => null,
                'label' => null,
                'template_html' => null,
                'template_js' => null,
                'operator' => '=',
                'criteria' => null,
            ])
            ->setAllowedTypes('type', ['null', 'string'])
            ->setAllowedTypes('name', ['null', 'string'])
            ->setAllowedTypes('label', ['null', 'string'])
            ->setAllowedTypes('criteria', ['null', 'callable'])
        ;

        return $this;
    }
}
