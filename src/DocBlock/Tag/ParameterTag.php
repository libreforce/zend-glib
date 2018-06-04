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


class ParameterTag extends AbstractAnnotatableTag implements TagInterface
{
    /**
     * @var string
     */
    protected $variableName;

    /**
     * @param string $variableName
     * @param array $types
     * @param string $description
     */
    public function __construct($variableName = null, $annotations = [], $description = null)
    {
        if (! empty($variableName)) {
            $this->setVariableName($variableName);
        }

        parent::__construct($annotations, $description);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getVariableName();
    }

    /**
     * @param string $variableName
     * @return ParamTag
     */
    public function setVariableName($variableName)
    {
        $this->variableName = $variableName;
        return $this;
    }

    /**
     * @return string
     */
    public function getVariableName()
    {
        return $this->variableName;
    }

    /**
     * @return string
     */
    public function generate()
    {
        $num_annotations = count($this->annotations);

        $output  = '@';
        $output .= $this->variableName;
        $output .= ': ';

        $glue = '';
        for ($i=0; $i < $num_annotations; $i++) {
            $annotation = $this->annotations[$i];
            $output .= $glue . '(' . $annotation . ')';
            $glue = ' ';
        }
        if ($num_annotations) {
            $output .= ': ';
        }

        $output .= empty($this->description) ? '' : $this->description;

        return $output;
    }
}
