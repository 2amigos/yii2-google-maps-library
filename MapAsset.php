<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps;

use Yii;
use yii\web\AssetBundle;

class MapAsset extends AssetBundle
{
    public function init()
    {
        // To configure please, add `googleMapsApiKey` parameter to your application configuration
        // file with the value of your API key. To get yours, please visit https://code.google.com/apis/console/.
        $key = @Yii::$app->params['googleMapsApiKey'];

        $this->js[] = 'https://maps.googleapis.com/maps/api/js?key=' . $key;
    }
} 