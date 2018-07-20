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
class MethodGenerator extends AbstractGenerator
{
    const VISIBILITY_PUBLIC    = 0x01;
    const VISIBILITY_PROTECTED = 0x02;
    const VISIBILITY_PRIVATE   = 0x03;

    /**
     * @var string
     */
    protected $name;
    /**
     * @var TypeGenerator
     */
    protected $type;
    /*
    protected $typePass;
    //protected $type_modifier; unsigned ...
    //protected $type_qualifier; const
    */
    protected $isStatic = FALSE;
    protected $isVirtual = FALSE;
    protected $isOverride = FALSE;
    protected $visibility = self::VISIBILITY_PUBLIC;
    protected $parameters = [];
    protected $objectName;

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

    public function setObjectName($objectName)
    {
        $this->objectName = $objectName;
        return $this;
    }

    public function getObjectName()
    {
        if ($this->objectName==NULL) {
            $this->objectName = $this->getParentGenerator()->getNamespaceName();
            $this->objectName .= $this->getParentGenerator()->getName();
        }
        return $this->objectName;
    }


    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setTypePass($pass)
    {
        $this->typePass = $pass;
        return $this;
    }

    public function getTypePass()
    {
        return $this->typePass;
    }


    /*
    public function addParameter($parameter) {
        if ( $parameter instanceof ParameterGenerator ) {
            $this->parameters[] = $parameter;
        } else if ( is_string($parameter) ) {
            $parameter = new ParameterGenerator($parameter);
            $this->parameters[] = $parameter;
        }
        return $parameter;
    }
    */

    /**
     * @param  ParameterGenerator|array|string $parameter
     * @throws Exception\InvalidArgumentException
     * @return MethodGenerator
     */
    public function setParameter($parameter)
    {
        if (is_string($parameter) || is_array($parameter)) {
            $parameter = new ParameterGenerator($parameter);
        }

        if (! $parameter instanceof ParameterGenerator) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s is expecting either a string, array or an instance of %s\ParameterGenerator',
                __METHOD__,
                __NAMESPACE__
            ));
        }

        $this->parameters[$parameter->getName()] = $parameter;

        return $this;
    }

    /**
     * viewer-file.h
     * ViewerFile *viewer_file_new (void);
     *
     * @return string
     */
    public function generateHeader()
    {
        $output = '';// const unsigned char *argv[]
        $tab = str_repeat($this->getIndentation(), 1);

        $naming = new Naming\GnomeStrategy();
        $function_name = $naming->generateFunctionName($this);
        $type_name = $naming->generateTypeName($this->getParentGenerator());

        $output .= $this->getType() . self::LINE_FEED;
        $output .= $function_name . '(';
        $output .= $type_name . '* self';
        $glue = ', ';
        foreach ($this->parameters as $parameter) {
            $output .= $glue . $parameter->generate('header');
        }
        $output .= ', GError **error';
        $output .= ');' . self::LINE_FEED;

        return $output;
    }

    /**
     * void (*open) (ViewerFile  *self, GError **error);
     * @return string
     */
    public function generateHeaderBoiler()
    {
        $output = '';// const unsigned char *argv[]

            $camelCaseToUnderscore = new \Zend\Filter\Word\CamelCaseToUnderscore();
            $stringToLower = new \Zend\Filter\StringToLower();
            $object_name = $stringToLower->filter($camelCaseToUnderscore->filter($this->getName()));

        $output .= $this->getType() . ' ';
        $output .= '(*' . $object_name . ') (';
        $output .= $this->getObjectName() . '* self';
        $glue = ', ';
        for ($i=0; $i<count($this->parameters); $i++) {
            $parameter = $this->parameters[$i];
            $output .= $glue . $parameter->generate();
        }
        $output .= ');' . self::LINE_FEED;

        return $output;
    }

    /**
     * @return string
     */
    public function generateSourceBoiler()
    {
        $output = '';// const unsigned char *argv[]
        $tab = $this->getIndentation();
        /*
        $camelCaseToUnderscore = new \Zend\Filter\Word\CamelCaseToUnderscore();
        $stringToLower = new \Zend\Filter\StringToLower();
        $stringToUpper = new \Zend\Filter\StringToUpper();

        $objectClass;// DomNodeClass
        $objectCheck;// DOM_IS_NODE
        $objectCast;//DOM_NODE
        */

        $output .= $this->getType() . self::LINE_FEED;
        $namespaceName = $this->getParentGenerator()->getNamespaceName();
        $objectSimpleName = $this->getParentGenerator()->getName();
        $objectName = $this->getObjectName();
            $camelCaseToUnderscore = new \Zend\Filter\Word\CamelCaseToUnderscore();
            $stringToLower = new \Zend\Filter\StringToLower();
            $stringToUpper = new \Zend\Filter\StringToUpper();
            $object_name = $stringToLower->filter($camelCaseToUnderscore->filter($objectName));
            $OBJECT_NAME = $stringToUpper->filter($camelCaseToUnderscore->filter($objectName));
            $objectIsName = $stringToUpper->filter($camelCaseToUnderscore->filter($namespaceName));
            $objectIsName .= '_SI_' . $stringToUpper->filter($camelCaseToUnderscore->filter($objectSimpleName));
            $method_name = $stringToLower->filter($camelCaseToUnderscore->filter($this->getName()));

        $output .= $object_name . '_';
        $output .= $stringToLower->filter($camelCaseToUnderscore->filter($this->getName())) . '(';
        $output .= $this->getObjectName() . '* self';
        $glue = ', ';
        for ($i=0; $i<count($this->parameters); $i++) {
            $parameter = $this->parameters[$i];
            $output .= $glue . $parameter->generate('source');
        }
        $output .= ', GError **error';
        $output .= ') {' . self::LINE_FEED;
        $output .= $tab . $this->getObjectName() . 'Class *klass;' . self::LINE_FEED;
        $output .= $tab . self::LINE_FEED;
        $output .= $tab . 'g_return_if_fail(' . $objectIsName . '(self));' . self::LINE_FEED;
        $output .= $tab . 'g_return_if_fail (error == NULL || *error == NULL);' . self::LINE_FEED;
        $output .= $tab . self::LINE_FEED;
        $output .= $tab . 'klass = ' . $OBJECT_NAME . '_GET_CLASS (self);' . self::LINE_FEED;
        $output .= $tab . self::LINE_FEED;
        $output .= $tab . 'g_return_if_fail (klass->' . $method_name . ' != NULL);' . self::LINE_FEED;
        $output .= $tab . 'return klass->' . $method_name . ' (self, error);' . self::LINE_FEED;
        $output .= '}' . self::LINE_FEED;

        return $output;
    }

    /**
     * @return string
     */
    public function generateSource()
    {
        $output = '';// const unsigned char *argv[]
        $tab = str_repeat($this->getIndentation(), 1);

        $naming = new Naming\GnomeStrategy();
        $function_name = $naming->generateFunctionName($this);
        $type_name = $naming->generateTypeName($this->getParentGenerator());

        $output .= 'static ';
        $output .= $this->getType() . self::LINE_FEED;
        $output .= $function_name . '(';
        $output .= $type_name . '* self';
        $glue = ', ';
        foreach ($this->parameters as $parameter) {
            $output .= $glue . $parameter->generate('source');
        }
        $output .= ', GError **error';
        $output .= ') {' . self::LINE_FEED;
        $output .= '}' . self::LINE_FEED;

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
