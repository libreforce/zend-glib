<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\GLib\DocBlock;

use Zend\GLib\AbstractGenerator;

abstract class AbstractDocBlock extends AbstractGenerator
{
    public function format($text, $length=80, $decor=' * ') {
        $output = str_replace (PHP_EOL, ' ', $text);
        $output = wordwrap($output, $length, PHP_EOL);
        $lines = explode(PHP_EOL, $output);
        $glue = PHP_EOL . $decor;
        $output = $decor . implode($glue, $lines);

        return $output;
    }
}
