<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\layers;


class LabelColor
{
    const BLACK = 'google.maps.weather.LabelColor.BLACK';
    const WHITE = 'google.maps.weather.LabelColor.WHITE';

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