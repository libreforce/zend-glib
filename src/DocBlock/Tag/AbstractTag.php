<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\GLib\DocBlock\Tag;

use Zend\GLib\AbstractGenerator;
use Zend\GLib\DocBlock\Tag\TagInterface;

use function explode;
use function implode;
use function is_string;

/**
 * This abstract class can be used as parent for all tags
 * that use a type part in their content.
 *
 * @see http://www.phpdoc.org/docs/latest/for-users/phpdoc/types.html
 */
abstract class AbstractTag extends AbstractGenerator implements TagInterface
{
    /**
     * @var string
     */
    protected $description;

    /**
     * @param string|string[] $types
     * @param string          $description
     */
    public function __construct($description = null)
    {
        if (! empty($description)) {
            $this->setDescription($description);
        }
    }

    /**
     * @param string $description
     * @return ReturnTag
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

}
