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


class NamingGenerator extends AbstractGenerator
{

    /**
     * @var bool
     */
    protected $name;
    protected $strategy;

    public function setStrategy($strategy)
    {
        $this->strategy = $strategy;
        return $this;
    }

    public function getStrategy()
    {
        return $this->strategy;
    }

    /**
     * @return string
     */
    public function generate($scope)
    {
        $output = '';

        $generator = $this->getStrategy()->getGenerator();
        if ( $generator instanceof ClassGenerator ) {
            $anme = $generator->getName();
            $output = $this->getStrategy()->filter($anme);
        }

        return $output;
    }

    public function generateFunctionName()
    {
        $output = '';
        $generator = $this->getStrategy()->getGenerator();
        if ( $generator instanceof ClassGenerator ) {
            $namespace = $generator->getNamespaceName();
            $output .= $this->getStrategy()->filter($namespace);
            $name = $generator->getName();
            $output .= '_' . $this->getStrategy()->filter($name);
        }

        return $output;
    }

    public function generateTypeName()
    {
        $output = '';
        $generator = $this->getStrategy()->getGenerator();
        if ( $generator instanceof ClassGenerator ) {
            $namespace = $generator->getNamespaceName();
            $output .= $namespace;//$this->getStrategy()->filter($namespace);
            $name = $generator->getName();
            $output .= $name;//$this->getStrategy()->filter($name);
        }

        return $output;
    }

    public function generateMacroIsInterface()
    {
    }

    public function generateMacroIsInstance()
    {
    }

    public function generateMacroIsClass()
    {
    }

    public function generateMacroType($generator)
    {
        $camelCaseToUnderscore = new \Zend\Filter\Word\CamelCaseToUnderscore();
        $stringToUpper = new \Zend\Filter\StringToUpper();

        if ($generator instanceof Zend\GLib\ClassGenerator) {
            // ...
            $generate->getNamespaceName();
            $generate->getName();
            //...
        } else if ($generator instanceof Zend\GLib\MethodGenerator) {
            // ...
        } else {
            // ...
        }

    }

    public function generateMacroClass()
    {
        $output = '';
        $generator = $this->getStrategy()->getGenerator();
        if ( $generator instanceof ClassGenerator ) {
            $camelCaseToUnderscore = new \Zend\Filter\Word\CamelCaseToUnderscore();
            $stringToUpper = new \Zend\Filter\StringToUpper();

            $namespace = $generator->getNamespaceName();
            $name = $generator->getName();

            $output .= $stringToUpper->filter($camelCaseToUnderscore->filter($namespace));
            $output .= '_' . $stringToUpper->filter($camelCaseToUnderscore->filter($name));
        }

        return $output;
    }// MYSQL_NODE_CLASS($o)

    public function generateMacroInstance()
    {
    }

    public function generateProperty()
    {
        $output = '';
        $generator = $this->getStrategy()->getGenerator();
        if ( $generator instanceof ClassGenerator ) {
            $namespace = $generator->getNamespaceName();
            // CamelCaseToUnderscore
            // $camelCaseToUnderscore
            $camelCaseToDash = new \Zend\Filter\Word\CamelCaseToDash();
            $stringToLower = new \Zend\Filter\StringToLower();
            $output .= $stringToLower->filter($camelCaseToDash->filter($namespace));
            $name = $generator->getName();
            $output .= '-' . $stringToLower->filter($camelCaseToDash->filter($name));
        }

        return $output;
    }// MYSQL_NODE_CLASS($o)

}