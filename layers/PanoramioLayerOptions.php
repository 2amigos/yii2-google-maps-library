<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\layers;

use dosamigos\google\maps\ObjectAbstract;
use dosamigos\google\maps\OptionsTrait;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

class PanoramioLayerOptions extends ObjectAbstract
{
    use OptionsTrait;

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->options = ArrayHelper::merge(
            [
                'clickable' => null,
                'map' => null,
                'tag' => null,
                'userId' => null,
                'suppressInfoWindows' => null,
            ],
            $this->options
        );
    }

    public function setMap($value)
    {
        $this->options['map'] = new JsExpression($value);
    }
}