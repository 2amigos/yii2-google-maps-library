<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps;

use Yii;
use yii\web\AssetBundle;

/**
 * MapAsset
 *
 * Registers the google maps api
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class MapAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        // To configure please, add `googleMapsApiKey` parameter to your application configuration
        // file with the value of your API key. To get yours, please visit https://code.google.com/apis/console/.
        $key = @Yii::$app->params['googleMapsApiKey'];
        
        // To configure please, add `googleMapsLibraries` parameter to your application configuration
        $libraries = @Yii::$app->params['googleMapsLibraries'];

        // To configure please, add `googleMapsLanguage` parameter to your application configuration
        $language = @Yii::$app->params['googleMapsLanguage'];

        $this->js[] = 'https://maps.googleapis.com/maps/api/js?key=' . $key . '&libraries=' . $libraries . '&language=' . $language;
    }
} 
