<?php

/*
 *
 * @copyright Copyright (c) 2013-2019 2amigos 
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 *
 */

namespace dosamigos\google\maps;

use yii\web\JsExpression;

/**
 * LatLngLiteral
 *
 * Google maps LatLngLiteral object
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 *
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
