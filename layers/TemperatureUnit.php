<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\layers;


/**
 * TemperatureUnit
 *
 * The temperature unit displayed by the weather layer.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\layers
 */
class TemperatureUnit
{
    const CELSIUS = 'google.maps.weather.TemperatureUnit.CELSIUS';
    const FAHRENHEIT = 'google.maps.weather.TemperatureUnit.FAHRENHEIT';

    /**
     * Checks whether value is a valid [TemperatureUnit] constant.
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
                static::CELSIUS,
                static::FAHRENHEIT
            ]
        );
    }
} 