<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\services;


class DirectionsUnitSystem
{
    const IMPERIAL = 'google.maps.DirectionsUnitSystem.IMPERIAL';
    const METRIC = 'google.maps.DirectionsUnitSystem.METRIC';

    public static function getIsValid($value){
        return in_array(
            $value,
            [
                static::METRIC,
                static::IMPERIAL
            ]
        );
    }
} 