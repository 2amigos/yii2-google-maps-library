<?php
/**
 * @link https://github.com/2amigos/yii2-google-maps-library
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace dosamigos\google\maps\controls;


/**
 * ScaleControlStyle
 *
 * Identifiers for scale control ids.
 *
 * For further information please visit its
 * [documentation](https://developers.google.com/maps/documentation/javascript/reference#ScaleControlStyle) at
 * Google.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\controls
 */
class ScaleControlStyle
{
    const DEFAULT_STYLE = 'google.maps.ScaleControlStyle.DEFAULT';

    /**
     * Checks whether value is a valid [ScaleControlStyle] constant.
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
                static::DEFAULT_STYLE,
            ]
        );
    }
}
