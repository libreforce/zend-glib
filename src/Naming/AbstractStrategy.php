<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\GLib\Naming;


class AbstractStrategy
{

    /**
     * @var string
     */
    protected $name;
    protected $generator;

    /**
     *
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function setGenerator($generator)
    {
        $this->generator = $generator;
        return $this;
    }
    public function getGenerator()
    {
        return $this->generator;
    }

    public function generateFunctionName($generator=null)
    {
        $output = '';

        $camelCaseToUnderscore = new \Zend\Filter\Word\CamelCaseToUnderscore();
        $stringToLower = new \Zend\Filter\StringToLower();

        if ($generator instanceof \Zend\GLib\ClassGenerator) {
            $output  = $generator->getNamespaceName();
            $output .= '_';
            $output .= $generator->getName();
            $output = $stringToLower->filter($camelCaseToUnderscore->filter($output));
        } else if ($generator instanceof \Zend\GLib\MethodGenerator) {
            $output  = $generator->getParentGenerator()->getNamespaceName();
            $output .= $generator->getParentGenerator()->getName();
            $output .= '_';
            $output .= $generator->getName();
            $output = $stringToLower->filter($camelCaseToUnderscore->filter($output));
        } else if ($generator instanceof \Zend\GLib\ParameterGenerator) {
            $output .= $generator->getName();
            $output = $stringToLower->filter($camelCaseToUnderscore->filter($output));
        } else {
            $output .= '<not_implemented>';
        }


        return $output;
    }

    public function generateTypeName($generator=null)
    {
        $output = '';
        $stringToLower = new \Zend\Filter\StringToLower();
        $camelCaseToUnderscore = new \Zend\Filter\Word\CamelCaseToUnderscore();
        $underscoreToCamelCase = new \Zend\Filter\Word\UnderscoreToCamelCase();

        $filters = new \Zend\Filter\FilterChain();
        $filters->attach($camelCaseToUnderscore)
                ->attach($stringToLower)
                ->attach($underscoreToCamelCase);

        if ($generator instanceof \Zend\GLib\ClassGenerator) {
            $output  = $filters->filter($generator->getNamespaceName());
            $output .= $filters->filter($generator->getName());
        } else if ($generator instanceof \Zend\GLib\MethodGenerator) {
            $output  = $generator->getParentGenerator()->getNamespaceName();
            $output .= $generator->getParentGenerator()->getName();
            $output = $filters->filter($output);
        } else {
            $output .= '<NotImplemented>';
        }

        return $output;
    }

    public function generateMacroType($generator)
    {
        $output = '';
        $stringToUpper = new \Zend\Filter\StringToUpper();
        $camelCaseToUnderscore = new \Zend\Filter\Word\CamelCaseToUnderscore();

        $filters = new \Zend\Filter\FilterChain();
        $filters->attach($camelCaseToUnderscore)
                ->attach($stringToUpper);

        if ($generator instanceof \Zend\GLib\ClassGenerator) {
            $output  = $filters->filter($generator->getNamespaceName());
            $output .= '_TYPE_';
            $output .= $filters->filter($generator->getName());
        } else {
            $output .= '<NO_TYPE_IMPLEMENTED>';
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

    public function generateMacroClass()
    {
    }

    public function generate()
    {
    }

}
