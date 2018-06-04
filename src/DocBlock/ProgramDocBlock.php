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

use Zend\GLib\DocBlock\Tag\ShortDescriptionTag;
use Zend\GLib\DocBlock\Tag\ParameterTag;
use Zend\GLib\DocBlock\Tag\ArgTag;
use Zend\GLib\DocBlock\Tag\SynopsisTag;
use Zend\GLib\DocBlock\Tag\SeeAlsoTag;
use Zend\GLib\DocBlock\Tag\ReturnTag;

class ProgramDocBlock extends AbstractDocBlock
{
    protected $name;
    protected $description;
    protected $argTags;
    protected $returnTag;
    protected $synopsisTag;
    protected $shortDescriptionTag;

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

    public function setShortDescriptionTag($shortDescriptionTag) {
        if ($shortDescriptionTag instanceof ShortDescriptionTag ) {
            $this->shortDescriptionTag = $shortDescriptionTag;
        } else if ( is_string($shortDescriptionTag) ) {
            $this->shortDescriptionTag = new ShortDescriptionTag($shortDescriptionTag);
        }
        return $this;
    }
    public function getShortDescriptionTag() {
        return $this->shortDescriptionTag;
    }

    public function setSynopsisTag($synopsisTag) {
        if ($synopsisTag instanceof SynopsisTag ) {
            $this->synopsisTag = $synopsisTag;
        } else if ( is_string($synopsisTag) ) {
            $this->synopsisTag = new SynopsisTag($synopsisTag);
        }
        return $this;
    }
    public function getSynopsisTag() {
        return $this->synopsisTag;
    }

    public function setSeeAlsoTag($seeAlsoTag) {
        if ($seeAlsoTag instanceof SeeAlsoTag ) {
            $this->seeAlsoTag = $seeAlsoTag;
        } else if ( is_string($seeAlsoTag) ) {
            $this->seeAlsoTag = new SeeAlsoTag($seeAlsoTag);
        }
        return $this;
    }
    public function getSeeAlsoTag() {
        return $this->seeAlsoTag;
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

    public function addArgTag($tag) {
        if ( $tag instanceof ArgTag ) {
            $this->argTags[] = $tag;
        } else if ( is_string($tag) ) {
            $tag = new ArgTag($tag);
            $this->argTags[] = $tag;
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
        $output .= $tab . ' * PROGRAM:' . $this->getName() . $endl;

        if ($this->shortDescriptionTag) {
            $output .= $tab . ' * '
                    .  $this->getShortDescriptionTag()->generate() . $endl;
        }

        if ($this->synopsisTag) {
            $output .= $tab . ' * '
                    .  $this->getSynopsisTag()->generate() . $endl;
        }

        if ($this->seeAlsoTag) {
            $output .= $tab . ' * '
                    .  $this->getSeeAlsoTag()->generate() . $endl;
        }

        for ($i=0; $i<count($this->argTags); $i++) {
            $tag = $this->argTags[$i];
            $output .= $tab . ' * ' . $tag->generate() . $endl;
        }
        $output .= $tab . ' * ' . $endl;

        $output .= $this->format($this->getDescription(), 80-strlen($tab)-3, $tab . ' * ') . $endl;
        $output .= $tab . ' * ' . $endl;

        if ($this->returnTag) {
            $output .= $tab . ' * '
                    .  $this->getReturnTag()->generate() . $endl;
        }

        $output .= $tab . ' */' . $endl;

        return $output;
    }
}
