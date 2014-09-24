<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\services;


class DirectionsTravelMode
{
    const DRIVING = 'google.maps.DirectionsTravelMode.DRIVING';
    const WALKING = 'google.maps.DirectionsTravelMode.WALKING';
    const TRANSIT = 'google.maps.DirectionsTravelMode.TRANSIT';
    const BICYCLING = 'google.maps.DirectionsTravelMode.BICYCLING';

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