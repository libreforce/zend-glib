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


class StabilityTag extends AbstractTag implements TagInterface
{
    /**#@+
     * Stability types
     */
    const STABLE   = 'Stable'; // The intention of a Stable interface is to enable arbitrary third parties to develop applications to these interfaces, release them, and have confidence that they will run on all minor releases of the product (after the one in which the interface was introduced, and within the same major release). Even at a major release, incompatible changes are expected to be rare, and to have strong justifications.
    const UNSTABLE = 'Unstable'; // Unstable interfaces are experimental or transitional. They are typically used to give outside developers early access to new or rapidly changing technology, or to provide an interim solution to a problem where a more general solution is anticipated. No claims are made about either source or binary compatibility from one minor release to the next.
    const PRIVATE  = 'Private'; // An interface that can be used within the GNOME stack itself, but that is not documented for end-users. Such functions should only be used in specified and documented ways.
    const INTERNAL = 'Internal'; // An interface that is internal to a module and does not require end-user documentation. Functions that are undocumented are assumed to be Internal.
    /**#@-*/

    protected $name;

    /**
     * @param string $variableName
     * @param array $types
     * @param string $description
     */
    public function __construct($stability = null)
    {
        $this->name = 'stability';

        parent::__construct($stability);
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
        $output  = '@';
        $output .= $this->name;
        $output .= ': ';

        $output .= empty($this->description) ? '' : $this->description;

        return $output;
    }
}
