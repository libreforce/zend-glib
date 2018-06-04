<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\GLib\DocBlock\Tag;

use Zend\GLib\DocBlock\Tag\AbstractTag;

use function explode;
use function implode;
use function is_string;

/**
 * This abstract class can be used as parent for all tags
 * that use a annotation part in their content.
 *
 * @see https://developer.gnome.org/gtk-doc-manual/stable/documenting_symbols.html.fr annotations
 */
abstract class AbstractAnnotatableTag extends AbstractTag
{
    /**
     * @var array
     */
    protected $annotations = [];

    /**
     * @param string|string[] $annotations
     * @param string          $description
     */
    public function __construct($annotations = [], $description = null)
    {
        if (! empty($annotations)) {
            $this->setAnnotations($annotations);
        }

        if (! empty($description)) {
            $this->setDescription($description);
        }
    }

    /**
     * Array of annotations or string with annotations delimited by pipe (|)
     * e.g. array('int', 'null') or "int|null"
     *
     * @param array|string $annotations
     * @return ReturnTag
     */
    public function setAnnotations($annotations)
    {
        if (is_string($annotations)) {
            $annotations = explode('|', $annotations);
        }
        $this->annotations = $annotations;
        return $this;
    }

    /**
     * @return array
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }

    /**
     * @param string $delimiter
     * @return string
    public function getAnnotationsAsString($delimiter = '|')
    {
        return implode($delimiter, $this->annotations);
    }
     */
}