<?php
/**
 * @link https://github.com/2amigos/yii2-google-maps-library
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace dosamigos\google\maps;

use yii\web\JsExpression;

/**
 * LatLngLiteral
 *
 * Google maps LatLngLiteral object
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class LatLngLiteral extends LatLng
{
    /**
     * @return string the js constructor of the object
     */
    public function getJs()
    {
        return new JsExpression("{{$this->__toString()}}");
    }
}
