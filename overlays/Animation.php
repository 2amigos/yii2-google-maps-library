<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\overlays;


class Animation
{
    const DROP = 'google.maps.Animation.DROP';
    const BOUNCE = 'google.maps.Animation.BOUNCE';

    public static function getIsValid($value){
        return in_array(
            $value,
            [
                static::DROP,
                static::BOUNCE
            ]
        );
    }
} 