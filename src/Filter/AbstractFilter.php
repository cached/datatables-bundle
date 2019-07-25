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
    protected $options;

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
    public function getType()
    {
        return $this->options['type'];
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
    public function getTemplateHtml()
    {
        return $this->options['template_html'];
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->options['field'];
    }

    /**
     * @return string
     */
    public function getLeftExpr()
    {
        $leftExpr = $this->options['leftExpr'];
        
        if ($leftExpr === nul) {
            return $this->getField();
        }

        if (is_callable($leftExpr)) {
            return call_user_func($leftExpr, $this->getField());
        }

        return $leftExpr;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->options['operator'];
    }

    /**
     * @return mixed
     */
    public function getRightExpr($value)
    {
        $rightExpr = $this->options['rightExpr'];
        
        if ($rightExpr === null) {
            return $value;
        }

        if (is_callable($rightExpr)) {
            return call_user_func($rightExpr, $value);
        }

        return $rightExpr;
    }

    /**
     * @return callable|null
     */
    public function getCriteria()
    {
        return $this->options['criteria'];
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
                'field' => null,
                'leftExpr' => null,
                'operator' => '=',
                'rightExpr' => null,
                'criteria' => null,
            ])
            ->setAllowedTypes('type', ['null', 'string'])
            ->setAllowedTypes('name', ['null', 'string'])
            ->setAllowedTypes('label', ['null', 'string'])
            ->setAllowedTypes('field', ['null', 'string'])
            ->setAllowedTypes('leftExpr', ['null', 'string', 'callable'])
            ->setAllowedTypes('rightExpr', ['null', 'string', 'callable'])
            ->setAllowedTypes('criteria', ['null', 'callable'])
        ;

        return $this;
    }
}
