<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps;

use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\base\Object;

/**
 * Event
 *
 * Google maps event
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class Event extends Object
{
    /**
     * @var string the action that will trigger the event
     */
    public $trigger;
    /**
     * @var string the javascript code to be executed
     */
    public $js;
    /**
     * @var bool whether to wrap the js code within a javascript function (ie `"function(){ $js }"`)
     */
    public $wrap = true;
    /**
     * @var string the type of event. Defaults to [[EventType::DEFAULT_EVENT]]
     */
    private $_type = EventType::DEFAULT_EVENT;


    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->trigger)) {
            throw new InvalidConfigException('"$trigger" cannot be null.');
        }
        if (empty($this->js)) {
            throw new InvalidConfigException('"js" cannot be null.');
        }
        parent::init();
    }

    /**
     * Sets the type of event, by default Google Event
     *
     * @param string $value
     *
     * @throws \yii\base\InvalidParamException
     */
    public function setType($value)
    {
        if (!EventType::getIsValid($value)) {
            throw new InvalidParamException('Unrecognized event type');
        }
        $this->_type = $value;
    }

    /**
     * Returns type of event
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Returns the js function to be executed
     * @return string
     */
    public function getFunction()
    {
        return $this->wrap
            ? "function(event){{$this->js}}"
            : $this->js;
    }

    /**
     * Returns the javascript code for attaching a Google event to a javascript object
     *
     * @param string $name the javascript object name to attach the event to
     * @param bool $once whether to make a one time call event or not
     *
     * @return string
     */
    public function getEventJs($name, $once = false)
    {
        $once = ($once) ? 'Once' : '';
        return "google.maps.event.addListener$once($name, '{$this->trigger}', {$this->getFunction()});";
    }

    /**
     * Returns the javascript code for attaching a dom event to a javascript object
     *
     * @param string $name
     * @param bool $once
     *
     * @return string
     */
    public function getDomEventJs($name, $once = false)
    {
        $once = ($once) ? 'Once' : '';
        return "google.maps.event.addDomListener$once($name, '{$this->trigger}', {$this->getFunction()});";
    }

    /**
     * Returns the js code to attach a Google event or a Dom event to a js object
     *
     * @param string $name the object name
     *
     * @return string the js event
     */
    public function getJs($name)
    {
        switch ($this->getType()) {
            case EventType::DEFAULT_ONCE:
                return $this->getEventJs($name, true);
            case EventType::DOM:
                return $this->getDomEventJs($name);
            case EventType::DOM_ONCE:
                return $this->getDomEventJs($name, true);
            case EventType::DEFAULT_EVENT:
            default:
                return $this->getEventJs($name);
        }
    }
} 
