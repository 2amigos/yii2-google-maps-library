<?php
/**
 * @link https://github.com/2amigos/yii2-google-maps-library
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace dosamigos\google\maps;

use yii\web\JsExpression;

/**
 * PluginAbstract
 *
 * Abstract object where all plugins should extend from.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
abstract class PluginAbstract extends ObjectAbstract
{

    /**
     * Sets the map name
     * @param string $value
     */
    public function setMap($value)
    {
        $this->options['map'] = new JsExpression($value);
    }

    /**
     * @return string the processed js events
     */
    public function getEvents()
    {
        $js = [];
        if (!empty($this->events)) {
            foreach ($this->events as $event) {
                /** @var Event $event */
                if (!($event instanceof Event)) {
                    continue; // only Google Events allowed
                }
                $js[] = $event->getJs($this->getName());
            }
        }
        return !empty($js) ? implode("\n", $js) : "";
    }

    /**
     * Returns the plugin name
     * @return string
     */
    abstract public function getPluginName();

    /**
     * Registers plugin asset bundle
     *
     * @param \yii\web\View $view
     *
     * @return mixed
     */
    abstract public function registerAssetBundle($view);
}
