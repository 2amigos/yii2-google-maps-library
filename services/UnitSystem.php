<?php

/*
 *
 * @copyright Copyright (c) 2013-2019 2amigos 
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 *
 */

namespace dosamigos\google\maps\services;

/**
 * UnitSystem
 *
 * The valid unit systems that can be specified in a DirectionsRequest.
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * 
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\services
 */
class UnitSystem
{
    const IMPERIAL = 'google.maps.UnitSystem.IMPERIAL';
    const METRIC = 'google.maps.UnitSystem.METRIC';

    /**
     * Checks whether value is a valid [UnitSystem] constant.
     *
     * @param $value
     *
     * @return bool
     */
    public static function getIsValid($value)
    {
        return in_array(
            $value,
            [
                static::METRIC,
                static::IMPERIAL
            ],
            false
        );
    }
}
