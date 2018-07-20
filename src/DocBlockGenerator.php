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

use function explode;
use function is_array;
use function sprintf;
use function str_replace;
use function strtolower;
use function trim;
use function wordwrap;

class DocBlockGenerator extends AbstractGenerator
{

    /**
     * @var bool
     */
    protected $indentation = true;
    protected $length_line = true;
    protected $wordwrap = true;
    protected $author = true;
    protected $email = true;
    protected $object = true;

    /**
     */
    public function __construct()
    {
    }

    /**
     * @param bool $value
     * @return DocBlockGenerator
     */
    public function setWordWrap($value)
    {
        $this->wordwrap = (bool) $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function getWordWrap()
    {
        return $this->wordwrap;
    }

    /**
     * @return string
     */
    public function generate($scope)
    {
    }

    /**
     * @param  string $content
     * @return string
     */
    protected function docCommentize($content)
    {
        $indent  = $this->getIndentation();
        $output  = $indent . '/**' . self::LINE_FEED;
        $content = $this->getWordWrap() == true ? wordwrap($content, 80, self::LINE_FEED) : $content;
        $lines   = explode(self::LINE_FEED, $content);
        foreach ($lines as $line) {
            $output .= $indent . ' *';
            if ($line) {
                $output .= ' ' . $line;
            }
            $output .= self::LINE_FEED;
        }
        $output .= $indent . ' */' . self::LINE_FEED;

        return $output;
    }
}