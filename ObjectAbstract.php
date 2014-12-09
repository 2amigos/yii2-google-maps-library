<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps;


use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\base\InvalidParamException;

/**
 * ObjectAbstract
 *
 * ObjectAbstract class where most objects extend from
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
abstract class ObjectAbstract extends Object
{
    /**
     * @var integer a counter used to generate [[id]] for map objects.
     * @internal
     */
    public static $counter = 0;
    /**
     * @var string the prefix to the automatically generated object js variable names.
     * @see getName()
     */
    public static $autoNamePrefix = 'g';
    /**
     * @var array the client options of the object. Objects will be initialized with default options.
     */
    public $options = [];
    /**
     *
     * Event[] events attached to the object
     * @var array
     */
    protected $events = [];
    /**
     * @var string holds the name of the object that is going to be used as js variable name.
     */
    private $_name;

    /**
     * Returns the javascript code required to initialize the object
     * @return mixed
     */
    abstract public function getJs();

    /**
     * Returns the name of the object that is going to be used as a js variable of the renderer service.
     *
     * @param bool $autoGenerate whether to auto-generate the name or not
     *
     * @return string
     */
    public function getName($autoGenerate = true)
    {
        if (!empty($this->_name)) {
            return $this->_name;
        }
        if ($autoGenerate) {
            $reflection = new \ReflectionClass($this);
            $this->_name = self::$autoNamePrefix . Inflector::variablize(
                    $reflection->getShortName()
                ) . self::$counter++;
        }
        return $this->_name;
    }

    /**
     * Sets the Javascript name of the renderer service
     *
     * @param string $value
     */
    public function setName($value)
    {
        $this->_name = $value;
    }

    /**
     * Batch set events by an array of Event objects
     *
     * @param Event[] $events
     */
    public function setEvents($events)
    {
        $events = (array)$events;
        foreach ($events as $event) {
            $this->addEvent($event);
        }
    }

    /**
     * Adds an event listener to the rectangle
     *
     * @param Event $event
     */
    public function addEvent(Event $event)
    {
        $this->events[] = $event;
    }

    /**
     * Returns json encoded options to configure js objects
     * @return string
     */
    public function getEncodedOptions()
    {
        $options = [];

        foreach ($this->options as $key => $value) {
            if ($value === null) {
                continue;
            }
            $options[$key] = $this->encode($value);

        }

        return Json::encode($options);
    }

    /**
     * Makes sure a value is properly set to be JSON encoded
     *
     * @param mixed $value the value to encode
     *
     * @return string
     */
    protected function encode($value)
    {
        if (is_object($value) && method_exists($value, 'getJs')) {
            return new JsExpression($value->getJs());
        } elseif (is_bool($value)) {
            return new JsExpression(($value ? 'true' : 'false'));
        } elseif (is_array($value)) {
            $parsed = [];
            foreach ($value as $child) {
                $parsed[] = $this->encode($child);
            }
            return $parsed;
        }
        try {
            // a value may contain a valid JSON string
            return Json::decode($value);
        } catch (InvalidParamException $e) {

        }
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        // setters go first
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } elseif (array_key_exists($name, $this->options)) {
            $this->options[$name] = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        // getters go first
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }

        return ArrayHelper::keyExists($name, $this->options)
            ? $this->options[$name]
            : parent::__get($name);
    }

    /**
     * @inheritdoc
     */
    public function __isset($name)
    {
        return isset($this->options[$name]) || parent::__isset($name);
    }

    /**
     * @inheritdoc
     */
    public function __unset($name)
    {
        if (isset($this->options[$name])) {
            $this->options[$name] = null;
        } else {
            parent::__unset($name);
        }
    }
} 
