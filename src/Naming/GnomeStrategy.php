<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\GLib\Naming;

use \Zend\GLib\Naming\AbstractNaming;

use \Zend\Filter\Word\CamelCaseToUnderscore;
use \Zend\Filter\StringToLower;

class GnomeStrategy extends AbstractStrategy
{
    protected $camelCaseToUnderscore;
    protected $stringToLower;

    /**
     *
     */
    public function __construct($generator=null)
    {
        $this->camelCaseToUnderscore = new CamelCaseToUnderscore();
        $this->stringToLower = new StringToLower();

        $this->generator = $generator;
        parent::__construct('Gnome');
    }

    public function filter($name)
    {
        return $this->stringToLower->filter(
            $this->camelCaseToUnderscore->filter($name)
        );
    }

    public function generate()
    {
        //$filter = new \Zend\Filter\Word\CamelCaseToUnderscore();
        //$filter1 = new \Zend\Filter\StringToLower();
        //echo PHP_EOL . $filter1->filter($filter->filter('MySQL')) . PHP_EOL;
        return '_';
    }

}
