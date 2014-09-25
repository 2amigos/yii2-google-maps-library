<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\controls;

/**
 * ControlPosition
 *
 * Identifiers used to specify the placement of controls on the map. Controls are positioned relative to other controls
 * in the same layout position. Controls that are added first are positioned closer to the edge of the map.
 *
 * For further information please visit its
 * [documentation](https://developers.google.com/maps/documentation/javascript/reference#ControlPosition) at Google.
 *
 * ```
 * echo ControlPosition::TOP_CENTER;
 * ```
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\controls
 */
class ControlPosition
{
    const TOP_CENTER = 'google.maps.ControlPosition.TOP_CENTER';
    const TOP_LEFT = 'google.maps.ControlPosition.TOP_LEFT';
    const TOP_RIGHT = 'google.maps.ControlPosition.TOP_RIGHT';
    const LEFT_TOP = 'google.maps.ControlPosition.LEFT_TOP';
    const RIGHT_TOP = 'google.maps.ControlPosition.RIGHT_TOP';
    const LEFT_CENTER = 'google.maps.ControlPosition.LEFT_CENTER';
    const RIGHT_CENTER = 'google.maps.ControlPosition.RIGHT_CENTER';
    const LEFT_BOTTOM = 'google.maps.ControlPosition.LEFT_BOTTOM';
    const RIGHT_BOTTOM = 'google.maps.ControlPosition.RIGHT_BOTTOM';
    const BOTTOM_LEFT = 'google.maps.ControlPosition.BOTTOM_LEFT';
    const BOTTOM_CENTER = 'google.maps.ControlPosition.BOTTOM_CENTER';
    const BOTTOM_RIGHT = 'google.maps.ControlPosition.BOTTOM_RIGHT';

    /**
     * Checks whether the value is a valid [ControlPosition] constant.
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
                static::BOTTOM_CENTER,
                static::BOTTOM_LEFT,
                static::BOTTOM_RIGHT,
                static::LEFT_BOTTOM,
                static::LEFT_CENTER,
                static::LEFT_TOP,
                static::TOP_CENTER,
                static::TOP_LEFT,
                static::TOP_RIGHT
            ]
        );
    }
} 