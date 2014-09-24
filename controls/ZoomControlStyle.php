<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\controls;


/**
 * ZoomControlStyle
 *
 * Identifiers for the zoom control.
 *
 * For further information please visit its
 * [documentation](https://developers.google.com/maps/documentation/javascript/reference#ZoomControlStyle) at
 * Google.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\controls
 */
class ZoomControlStyle
{
    const DEFAULT_STYLE = 'google.maps.ZoomControlStyle.DEFAULT';
    const LARGE = 'google.maps.ZoomControlStyle.LARGE';
    const SMALL = 'google.maps.ZoomControlStyle.SMALL';

    /**
     * @param $value
     *
     * @return bool
     */
    public static function getIsValid($value){
        return in_array(
            $value,
            [
                static::DEFAULT_STYLE,
                static::LARGE,
                static::SMALL
            ]
        );
    }
} 