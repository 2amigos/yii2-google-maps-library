<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\overlays;


/**
 * SymbolPath
 *
 * Built-in symbol paths.
 *
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\overlays
 */
class SymbolPath
{
    const CIRCLE = 'google.maps.SymbolPath.CIRCLE';
    const BACKWARD_CLOSED_ARROW = 'google.maps.SymbolPath.BACKWARD_CLOSED_ARROW';
    const FORWARD_CLOSED_ARROW = 'google.maps.SymbolPath.FORWARD_CLOSED_ARROW';
    const BACKWARD_OPEN_ARROW = 'google.maps.SymbolPath.BACKWARD_OPEN_ARROW';
    const FORWARD_OPEN_ARROW = 'google.maps.SymbolPath.FORWARD_OPEN_ARROW';

    /**
     * Checks whether is a valid [SymbolPath] constant.
     *
     * @param string $value
     *
     * @return bool
     */
    public static function getIsValid($value){
        return in_array(
            $value,
            [
                static::CIRCLE,
                static::BACKWARD_CLOSED_ARROW,
                static::BACKWARD_OPEN_ARROW,
                static::FORWARD_CLOSED_ARROW,
                static::FORWARD_OPEN_ARROW
            ]
        );
    }
} 