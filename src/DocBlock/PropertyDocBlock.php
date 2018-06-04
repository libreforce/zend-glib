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

class PropertyDocBlock extends AbstractDocBlock
{
    protected $name;
    protected $description;

    protected $objectName;


    public function setObjectName($objectName) {
        $this->objectName = $objectName;
        return $this;
    }

    public function getObjectName() {
        return $this->objectName;
    }

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

    /**
     * @return string
     */
    public function generate()
    {
        $endl        = AbstractGenerator::LINE_FEED;
        $tab         = str_repeat($this->getIndentation(), 0);

        $output  = '';
        $output .= $tab . '/**' . $endl;
        $output .= $tab . ' * ' . $this->getObjectName() . ':' . $this->getName() . ':' . $endl;

        $output .= $tab . ' * ' . $endl;
        $output .= $this->format($this->getDescription(), 80-strlen($tab)-3, $tab . ' * ') . $endl;

        $output .= $tab . ' */' . $endl;

        return $output;
    }
}
/**
 * SomeWidget:some-property:
 *
 * Here you can document a property.
 */
//g_object_class_install_property (object_class, PROP_SOME_PROPERTY, ...);
