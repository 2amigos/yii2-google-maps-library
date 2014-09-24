<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\services;


use dosamigos\google\maps\LatLng;
use yii\base\InvalidConfigException;

/**
 * Class StreetViewPanorama
 *
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class StreetViewPanorama extends StreetViewPanoramaOptions
{

    public $nodeId;

    public function init()
    {
        if($this->nodeId == null) {
            throw new InvalidConfigException('"nodeId" cannot be null');
        }
    }

    /**
     * Sets the coordinate object of the marker. Required.
     *
     * @param LatLng $coord
     */
    public function setPosition(LatLng $coord)
    {
        $this->options['position'] = $coord;
    }


    /**
     * The constructor js code for the Marker object
     * @return string
     */
    public function getJs()
    {

        $js = [];

        $js[] = "var {$this->getName()} = new google.maps.StreetViewPanorama(document.getElementById('{$this->nodeId}',{$this->getEncodedOptions()});";

        foreach ($this->events as $event) {
            /** @var \dosamigos\google\maps\Event $event */
            $js[] = $event->getJs($this->getName());
        }

        return implode("\n", $js);
    }
} 