<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\services;


/**
 * TravelMode
 *
 * The valid travel modes that can be specified in a [DirectionsRequest] as well as the travel modes returned in a
 * DirectionsStep.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\services
 */
class TravelMode
{
    const DRIVING = 'google.maps.TravelMode.DRIVING';
    const WALKING = 'google.maps.TravelMode.WALKING';
    const TRANSIT = 'google.maps.TravelMode.TRANSIT';
    const BICYCLING = 'google.maps.TravelMode.BICYCLING';

    /**
     * Checks whether value is a valid [DirectionsTravelModel] constant.
     *
     * @param $value
     *
     * @return bool
     */
    public static function getIsValid($value){
        return in_array(
            $value,
            [
                static::DRIVING,
                static::WALKING,
                static::TRANSIT,
                static::BICYCLING
            ]
        );
    }
} 