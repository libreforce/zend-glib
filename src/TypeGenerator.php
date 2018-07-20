<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\GLib;

use \Zend\GLib\AbstractGenerator;


class TypeGenerator extends AbstractGenerator
{

    /**
     * @var bool
     */
     protected $name;
     protected $qualifier;
     protected $modifier;
     protected $pass;
     protected $isArray=False;
     protected $expressionArray;

    /**
     *
     */
    public function __construct($name)
    {
        $this->name = $name;
        //parent::__construct($name);
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * signed
     * unsigned
     * short
     * long
     */
    public function setModifier($modifier)
    {
        $this->modifier = $modifier;
        return $this;
    }

    public function getModifier()
    {
        return $this->modifier;
    }

    /**
     * const
     */
    public function setQualifier($qualifier)
    {
        $this->qualifier = $qualifier;
        return $this;
    }

    public function getQualifier()
    {
        return $this->qualifier;
    }

    /**
     * *
     * &
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
        return $this;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function setArray($isArray=True)
    {
        $this->isArray = $isArray;
        return $this;
    }

    public function isArray()
    {
        return $this->isArray;
    }

    public function setExpressionArray($expressionArray)
    {
        $this->expressionArray = $expressionArray;
        return $this;
    }

    public function getExpressionArray()
    {
        return $this->expressionArray;
    }


    /**
     * @return string
     */
    public function generate($scope)
    {
        $output = '';// const unsigned char *argv[3]

        if ($this->qualifier!=null) {
            $output .= $this->getQualifier() . ' ';
        }

        if ($this->modifier!=null) {
            $output .= $this->getModifier() . ' ';
        }

        $output .= $this->getName();

        if ($this->pass!=null) {
            $output .= $this->getPass();
        }

        /*
        if ($this->isArray()) {
            $output .= '[';
            if ($this->expressionArray!=NULL) {
                $output .= $this->expressionArray;
            }
            $output .= ']';
        }
        */

        return $output;
    }

}