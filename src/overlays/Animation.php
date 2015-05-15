<?php
/**
 * @link https://github.com/2amigos/yii2-google-maps-library
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace dosamigos\google\maps\overlays;


/**
 * Animation
 *
 * Animations that can be played on a marker. Use the setAnimation method on a [dosamigos\google\maps\overlays\Marker]
 * or the animation option to play an animation.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\overlays
 */
class Animation
{
    const DROP = 'google.maps.Animation.DROP';
    const BOUNCE = 'google.maps.Animation.BOUNCE';

    /**
     * Checks whether value is a valid [Animation] constant.
     *
     * @param $value
     *
     * @return bool
     */
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
