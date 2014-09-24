<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
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