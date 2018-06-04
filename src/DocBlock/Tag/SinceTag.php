<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\GLib\DocBlock\Tag;

//use Zend\Code\Generator\DocBlock\TagManager;


class SinceTag extends AbstractTag implements TagInterface
{
    protected $name;

    /**
     * @param string $variableName
     * @param array $types
     * @param string $description
     */
    public function __construct($version = null)
    {
        $this->name = 'Since';

        parent::__construct($version);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function generate()
    {
        $output  = '';
        $output .= $this->name;
        $output .= ': ';

        $output .= empty($this->description) ? '' : $this->description;

        return $output;
    }
}
