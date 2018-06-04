<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\GLib\DocBlock;

use Zend\GLib\DocBlock\AbstractDocBlock;
use Zend\GLib\AbstractGenerator;

use Zend\GLib\DocBlock\Tag\ParameterTag;
use Zend\GLib\DocBlock\Tag\ReturnTag;
use Zend\GLib\DocBlock\Tag\SinceTag;
use Zend\GLib\DocBlock\Tag\DeprecateTag;


class FunctionDocBlock extends AbstractDocBlock
{
    protected $name;
    protected $description;

    protected $parameterTags = [];
    protected $returnTag;
    protected $sinceTag;
    protected $deprecateTag;


    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function addTag($tag) {
        if ( $tag instanceof ParameterTag ) {
            $this->parameterTags[] = $tag;
        } else if ( $tag instanceof ReturnTag ) {
            $this->returnTag = $tag;
        } else if ( $tag instanceof SinceTag ) {
            $this->sinceTag = $tag;
        } else if ( $tag instanceof DeprecateTag ) {
            $this->deprecateTag = $tag;
        } else {
            // throw new Exception();
        }
        return $this;
    }

    public function addParameterTag($tag) {
        if ( $tag instanceof ParameterTag ) {
            $this->parameterTags[] = $tag;
        } else if ( is_string($tag) ) {
            $tag = new ParameterTag($tag);
            $this->parameterTags[] = $tag;
        }
        return $tag;
    }

    public function setParameterTags($tags) {
        $this->parameterTags = $tags;
        return $this;
    }

    public function setReturnTag($tag) {
        if ( $tag instanceof ReturnTag) {
            $this->returnTag = $tag;
        } else if ( is_string($tag) ) {
            $this->returnTag = new ReturnTag($tag);
        }
        return $this;
    }

    public function getReturnTag() {
        return $this->returnTag;
    }

    public function setSinceTag($tag) {
        if ( $tag instanceof SinceTag) {
            $this->sinceTag = $tag;
        } else if ( is_string($tag) ) {
            $this->sinceTag = new SinceTag($tag);
        }
        return $this;
    }

    public function getSinceTag() {
        return $this->sinceTag;
    }

    public function setDeprecateTag($tag) {
        if ( $tag instanceof DeprecateTag) {
            $this->deprecateTag = $tag;
        } else if ( is_string($tag) ) {
            $this->deprecateTag = new DeprecateTag($tag);
        }
        return $this;
    }

    public function getDeprecateTag() {
        return $this->deprecateTag;
    }


    /*
    public function addTag($tag) {
        if ($tag instanceof ParamTag) {

        }
        return $this;
    }
    */


    /**
     * @return string
     */
    public function generate()
    {
        $endl        = AbstractGenerator::LINE_FEED;
        $tab         = str_repeat($this->getIndentation(), 0);

        $output  = '';
        $output .= $tab . '/**' . $endl;
        $output .= $tab . ' * ' . $this->getName() . ':' . $endl;

        for ($i=0; $i<count($this->parameterTags); $i++) {
            $tag = $this->parameterTags[$i];
            $output .= $tab . ' * ' . $tag->generate() . $endl;
        }
        $output .= $tab . ' * ' . $endl;
        $output .= $this->format($this->getDescription(), 80-strlen($tab)-3, $tab . ' * ') . $endl;

        if ( $this->returnTag != NULL ) {
            $output .= $tab . ' * ' . $endl;
            $output .= $tab . ' * ' . $this->getReturnTag()->generate() . $endl;
        }

        if ( $this->sinceTag != NULL || $this->deprecateTag != NULL ) {
            $output .= $tab . ' * ' . $endl;
        }
        if ( $this->sinceTag != NULL ) {
            $output .= $tab . ' * ' . $this->getSinceTag()->generate() . $endl;
        }
        if ( $this->deprecateTag != NULL ) {
            $output .= $tab . ' * ' . $this->getDeprecateTag()->generate() . $endl;
        }

        $output .= $tab . ' */' . $endl;

        return $output;
    }
}
/**
 * function_name:
 * @par1:  description of parameter 1. These can extend over more than
 * one line.
 * @par2:  description of parameter 2
 * @...: a %NULL-terminated list of bars
 *
 * The function description goes here. You can use @par1 to refer to parameters
 * so that they are highlighted in the output. You can also use %constant
 * for constants, function_name2() for functions and #GtkWidget for links to
 * other declarations (which may be documented elsewhere).
 *
 * Returns: an integer.
 *
 * Since: 2.2
 * Deprecated: 2.18: Use other_function() instead.
 */