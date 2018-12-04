<?php

namespace Admin\Form\Element;

use Interop\Container\ContainerInterface;
use Zend\Form\Element\Select;

class ConversionTypeSelect extends Select
{
    public function __construct(ContainerInterface $container, $name = null, array $options = [])
    {
        parent::__construct($name, $options);
    }

    public function getValueOptions()
    {
        if (count($this->valueOptions) == 0) {
            $foo = 'bar';
        }

        return $this->valueOptions;
    }
}