<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\services;

use dosamigos\google\maps\ObjectAbstract;
use yii\base\InvalidConfigException;

/**
 * DirectionsService
 *
 * Object to render the service for computing directiosn between two or more places.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class DirectionsService extends ObjectAbstract
{

    /**
     * @var DirectionsRequest
     */
    private $_request;
    /**
     * @var DirectionsRenderer
     */
    private $_renderer;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if($this->getDirectionsRenderer() == null) {
            throw new InvalidConfigException('"directionsRenderer" cannot be null');
        }
        if($this->getDirectionsRequest() == null) {
            throw new InvalidConfigException('"directionsRequest" cannot be null');
        }
    }

    /**
     * Sets directions request
     * @param DirectionsRequest $request
     */
    public function setDirectionsRequest(DirectionsRequest $request)
    {
        $this->_request = $request;
    }


    /**
     * Returns the directions request object
     * @return DirectionsRequest
     */
    public function getDirectionsRequest()
    {
        return $this->_request;
    }

    /**
     * Sets the directions renderer object
     * @param DirectionsRenderer $renderer
     */
    public function setDirectionsRenderer(DirectionsRenderer $renderer)
    {
        $this->_renderer = $renderer;
    }

    /**
     * Returns the directions renderer
     * @return DirectionsRequest
     */
    public function getDirectionsRenderer()
    {
        return $this->_renderer;
    }

    /**
     * Returns the javascript initialization code
     */
    public function getJs()
    {
        $renderer = $this->getDirectionsRenderer();
        $request = $this->getDirectionsRequest();

        $js[] = $renderer->getJs();
        $js[] = $request->getJs();
        $js[] = "var {$this->getName()} = new google.maps.DirectionsService();";
        $js[] = "{$this->getName()}.route({$request->getName()}, function(response, status) {";
        $js[] = "if (status == google.maps.DirectionsStatus.OK) {";
        $js[] = "{$renderer->getName()}.setDirections(response);";
        $js[] = "}});";

        return implode("\n", $js);
    }
} 