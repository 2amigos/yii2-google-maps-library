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

/**
 * KmlLayerOptions
 *
 * This object defines the properties that can be set on a [KmlLayer] object.
 *
 * @property boolean clickable If true, the layer receives mouse events. Default value is true.
 * @property string map The map on which to display the layer.
 * @property boolean preserveViewport By default, the input map is centered and zoomed to the bounding box of the
 * contents of the layer. If this option is set to true, the viewport is left unchanged, unless the map's center and
 * zoom were never set.
 * @property boolean screenOverlays Whether to render the screen overlays. Default true.
 * @property boolean suppressInfoWindows Suppress the rendering of info windows when layer features are clicked.
 * @property string url The URL of the KML document to display.
 * @property int zIndex The z-index of the layer.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\layers
 */
class KmlLayerOptions extends ObjectAbstract
{
    use OptionsTrait;

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->options = ArrayHelper::merge(
            [
                'clickable' => null,
                'map' => null,
                'preserveViewPort' => null,
                'screenOverlays' => null,
                'suppressInfoWindows' => null,
                'url' => null,
                'zIndex' => null
            ],
            $this->options
        );
    }

    public function setMap($value)
    {
        $this->options['map'] = new JsExpression($value);
    }
}