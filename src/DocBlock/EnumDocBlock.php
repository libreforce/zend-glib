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

class EnumDocBlock extends AbstractDocBlock
{
    protected $name;
    protected $description;
    protected $parameterTags;

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

    public function addParameterTag($tag) {
        if ( $tag instanceof ParameterTag ) {
            $this->parameterTags[] = $tag;
        } else if ( is_string($tag) ) {
            $tag = new ParameterTag($tag);
            $this->parameterTags[] = $tag;
        }
        return $tag;
    }

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

        $output .= $tab . ' */' . $endl;

        return $output;
    }
}
