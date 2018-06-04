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

use Zend\GLib\DocBlock\Tag\ImageTag;
use Zend\GLib\DocBlock\Tag\ShortDescriptionTag;
use Zend\GLib\DocBlock\Tag\TitleTag;
use Zend\GLib\DocBlock\Tag\SectionIdTag;
use Zend\GLib\DocBlock\Tag\SeeAlsoTag;
use Zend\GLib\DocBlock\Tag\StabilityTag;
use Zend\GLib\DocBlock\Tag\IncludeTag;


class SectionDocBlock extends AbstractDocBlock
{
    protected $name;
    protected $description;

    protected $imageTag;
    protected $shortDescriptionTag;
    protected $titleTag;
    protected $sectionIdTag;
    protected $seeAlsoTag;
    protected $stabilityTag;
    protected $includeTag;

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

    public function setImageTag($imageTag) {
        if ($imageTag instanceof ImageTag ) {
            $this->imageTag = $imageTag;
        } else if ( is_string($imageTag) ) {
            $this->imageTag = new ImageTag($imageTag);
        }
        return $this;
    }
    public function getImageTag() {
        return $this->imageTag;
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

    public function setTitleTag($titleTag) {
        if ($titleTag instanceof TitleTag ) {
            $this->titleTag = $titleTag;
        } else if ( is_string($titleTag) ) {
            $this->titleTag = new TitleTag($titleTag);
        }
        return $this;
    }
    public function getTitleTag() {
        return $this->titleTag;
    }

    public function setSectionIdTag($sectionIdTag) {
        if ($sectionIdTag instanceof SectionIdTag ) {
            $this->sectionIdTag = $sectionIdTag;
        } else if ( is_string($sectionIdTag) ) {
            $this->sectionIdTag = new SectionIdTag($sectionIdTag);
        }
        return $this;
    }
    public function getSectionIdTag() {
        return $this->sectionIdTag;
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

    public function setStabilityTag($stabilityTag) {
        if ($stabilityTag instanceof StabilityTag ) {
            $this->stabilityTag = $stabilityTag;
        } else if ( is_string($stabilityTag) ) {
            $this->stabilityTag = new StabilityTag($stabilityTag);
        }
        return $this;
    }
    public function getStabilityTag() {
        return $this->stabilityTag;
    }

    public function setIncludeTag($includeTag) {
        if ($includeTag instanceof IncludeTag ) {
            $this->includeTag = $includeTag;
        } else if ( is_string($includeTag) ) {
            $this->includeTag = new IncludeTag($includeTag);
        }
        return $this;
    }
    public function getIncludeTag() {
        return $this->includeTag;
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
        $output .= $tab . ' * ' . 'SECTION: ' . $this->name . $endl;
        if ($this->shortDescriptionTag) {
            $output .= $tab . ' * '
                    .  $this->getShortDescriptionTag()->generate() . $endl;
        }
        if ($this->titleTag) {
            $output .= $tab . ' * '
                    .  $this->getTitleTag()->generate() . $endl;
        }
        if ($this->sectionIdTag) {
            $output .= $tab . ' * '
                    .  $this->getSectionIdTag()->generate() . $endl;
        }
        if ($this->seeAlsoTag) {
            $output .= $tab . ' * '
                    .  $this->getSeeAlsoTag()->generate() . $endl;
        }
        if ($this->stabilityTag) {
            $output .= $tab . ' * '
                    .  $this->getStabilityTag()->generate() . $endl;
        }
        if ($this->includeTag) {
            $output .= $tab . ' * '
                    .  $this->getIncludeTag()->generate() . $endl;
        }
        if ($this->imageTag) {
            $output .= $tab . ' * '
                    .  $this->getImageTag()->generate() . $endl;
        }
        $output .= $tab . ' * ' . $endl;
        $output .= $tab . ' * ' . $this->getDescription() . $endl;
        $output .= $tab . ' */' . $endl;

        return $output;
    }
}
