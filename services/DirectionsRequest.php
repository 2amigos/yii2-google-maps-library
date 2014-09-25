<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\services;

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\ObjectAbstract;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * DirectionsRequest
 *
 * DirectionsRequest allows to easily configure a directions request js object. For further information please visit:
 * https://developers.google.com/maps/documentation/javascript/reference#DirectionsResult
 *
 * @property boolean avoidFerries If true, instructs the Directions service to avoid ferries where possible. Optional.
 * @property boolean avoidHighways If true, instructs the Directions service to avoid highways where possible. Optional.
 * @property boolean avoidTolls If true, instructs the Directions service to avoid toll roads where possible. Optional.
 * @property LatLng|string destination Location of destination. This can be specified as either a string to be geocoded
 * or a LatLng. Required.
 * @property boolean durationInTraffic Whether or not we should provide trip duration based on current traffic conditions.
 * Only available to Maps API for Work customers.
 * @property boolean optimizeWaypoints If set to true, the DirectionService will attempt to re-order the supplied
 * intermediate waypoints to minimize overall cost of the route. If waypoints are optimized, inspect
 * DirectionsRoute.waypoint_order in the response to determine the new ordering.
 * @property LatLng|string origin Location of origin. This can be specified as either a string to be geocoded or a
 * LatLng. Required.
 * @property boolean provideRouteAlternatives Whether or not route alternatives should be provided. Optional.
 * @property string region Region code used as a bias for geocoding requests. Optional.
 * @property array transitOptions Settings that apply only to requests where travelMode is TRANSIT. This object will
 * have no effect for other travel modes.
 * @property boolean travelMode Type of routing requested. Required.
 * @property boolean unitSystem Preferred unit system to use when displaying distance. Defaults to the unit
 * system used in the country of origin.
 * @property DirectionsWayPoint[] waypoints Array of intermediate waypoints. Directions will be calculated from the
 * origin to the destination by way of each waypoint in this array. The maximum allowed waypoints is 8, plus the origin,
 * and destination. Maps API for Work customers are allowed 23 waypoints, plus the origin, and destination.
 * Waypoints are not supported for transit directions. Optional.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class DirectionsRequest extends ObjectAbstract
{
    /**
     * @inheritdoc
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->options = ArrayHelper::merge(
            [
                'avoidFerries' => null,
                'avoidHighways' => null,
                'avoidTolls' => null,
                'destination' => null,
                'durationInTraffic' => null,
                'optimizeWaypoints' => null,
                'origin' => null,
                'provideRouteAlternatives' => null,
                'region' => null,
                'transitOptions' => null,
                'travelMode' => TravelMode::DRIVING,
                'unitSystem' => null,
                'waypoints' => null,
            ],
            $this->options
        );

        return parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->origin == null || $this->destination == null || $this->travelMode == null) {
            throw new InvalidConfigException('"origin", "destination" and/or "travelMode" are required');
        }
    }

    /**
     * Sets the origin ensuring is a LatLng type of object
     *
     * @param LatLng $origin
     */
    public function setOrigin(LatLng $origin)
    {
        $this->options['origin'] = $origin;
    }

    /**
     * Sets the destination ensuring is a LatLng type of object
     *
     * @param LatLng $destination
     */
    public function setDestination(LatLng $destination)
    {
        $this->options['destination'] = $destination;
    }

    /**
     * Sets the travelMode
     *
     * @param string $value
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function setTravelMode($value)
    {
        if (!TravelMode::getIsValid($value)) {
            throw new InvalidConfigException('Invalid "travelMode" value');
        }
        $this->options['travelMode'] = new JsExpression($value);
    }

    /**
     * Sets the directions wayPoints. Please, check the maximum allowed way points (without premier is 8)
     *
     * @param array $wayPoints
     */
    public function setWayPoints(array $wayPoints)
    {
        $values = [];
        foreach ($wayPoints as $wayPoint) {
            /** @var DirectionsWayPoint $wayPoint */
            if ($wayPoint instanceof DirectionsWayPoint) {
                $values[] = new JsExpression($wayPoint->getJs());
            }
            if ($wayPoint instanceof JsExpression) {
                $values[] = $wayPoint;
            }
        }
        $this->options['waypoints'] = $values;
    }

    /**
     * Returns the request anonymous object constructor
     * @return string
     */
    public function getJs()
    {
        return "var {$this->getName()} = {$this->getEncodedOptions()};";
    }
} 