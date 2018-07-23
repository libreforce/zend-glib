<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\GLib;

//use Zend\Code\Generator\DocBlock\Tag;
//use Zend\Code\Generator\DocBlock\Tag\TagInterface;
//use Zend\Code\Generator\DocBlock\TagManager;
//use Zend\Code\Reflection\DocBlockReflection;
use \Zend\GLib\AbstractGenerator;

use function explode;
use function is_array;
use function sprintf;
use function str_replace;
use function strtolower;
use function trim;
use function wordwrap;

// my_object_class_init(const GObject &object)
class NamespaceGenerator extends AbstractGenerator
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var AbstractDocBlock
     */
    protected $docBlock;

    /**
     *
     */
    public function __construct()
    {
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
     * viewer-file.h
     * ViewerFile *viewer_file_new (void);
     *
     * @return string
     */
    public function generateHeader()
    {
        $list = [];
        for ( $parentGenerator = $this; $parentGenerator!=NULL; $parentGenerator = $parentGenerator->getParentGenerator()) {
            $list[] = $parentGenerator->getName();
        }

        $list = array_reverse($list);
        return implode('::', $list);
    }

    /**
     * void (*open) (ViewerFile  *self, GError **error);
     * @return string
     */
    public function generateHeaderBoiler()
    {
        $output = '';// const unsigned char *argv[]

        return $output;
    }

    /**
     * @return string
     */
    public function generateSourceBoiler()
    {
        $output = '';// const unsigned char *argv[]

        return $output;
    }

    /**
     * @return string
     */
    public function generateSource()
    {
        $output = '';// const unsigned char *argv[]

        return $output;
    }

    /**
     * @return string
     */
    public function generate($scope)
    {
        switch ($scope) {
            case 'header':
                return $this->generateHeader();
            break;
            case 'source':
                return $this->generateSource();
            default:
            break;
        }
        //echo $this->generateHeaderBoiler() . PHP_EOL;
        //echo $this->generateSourceBoiler() . PHP_EOL;

        return '';
    }
}
