<?php
/**
 * @link https://github.com/2amigos/yii2-google-maps-library
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace dosamigos\google\maps\layers;

/**
 * LabelColor
 *
 * The color of the labels displayed on the weather layer.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\layers
 */
class LabelColor
{
    const BLACK = 'google.maps.weather.LabelColor.BLACK';
    const WHITE = 'google.maps.weather.LabelColor.WHITE';

    /**
     * Checks whether a value is a valid [LabelColor] constant.
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
                static::BLACK,
                static::WHITE
            ]
        );
    }
}
