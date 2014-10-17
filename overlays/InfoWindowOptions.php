<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\overlays;


use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\ObjectAbstract;
use dosamigos\google\maps\OptionsTrait;
use dosamigos\google\maps\Size;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * InfoWindowOptions
 *
 * Eases the configuration of an InfoWindow
 *
 * @property string content Content to display in the InfoWindow. This can be an HTML element, a plain-text string, or
 * a string containing HTML. The InfoWindow will be sized according to the content. To set an explicit size for the
 * content, set content to be a HTML element with that size.
 * @property boolean disableAutoPan Disable auto-pan on open. By default, the info window will pan the map so that it
 * is fully visible when it opens.
 * @property int maxWidth Maximum width of the infowindow, regardless of content's width. This value is only considered
 * if it is set before a call to open. To change the maximum width when changing content, call close, setOptions,
 * and then open.
 * @property Size pixelOffset The offset, in pixels, of the tip of the info window from the point on the map at whose
 * geographical coordinates the info window is anchored. If an InfoWindow is opened with an anchor, the pixelOffset
 * will be calculated from the anchor's anchorPoint property.+
 * @property [\dosamigos\google\maps\LatLng]|[\dosamigos\google\maps\LatLngLiteral] position The LatLng at which to display
 * this InfoWindow. If the InfoWindow is opened
 * with an anchor, the anchor's position will be used instead.
 * @property int zIndex All InfoWindows are displayed on the map in order of their zIndex, with higher values displaying
 * in front of InfoWindows with lower values. By default, InfoWindows are displayed according to their latitude, with
 * InfoWindows of lower latitudes appearing in front of InfoWindows at higher latitudes. InfoWindows are always
 * displayed in front of markers.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class InfoWindowOptions extends ObjectAbstract
{
    use OptionsTrait;

    /**
     * @inheritdoc
     *
     * @param array $config
     */
    public function __construct($config = [])
    {

        $this->options = ArrayHelper::merge(
            [
                'clickable' => null,
                'draggable' => null,
                'editable' => null,
                'geodesic' => null,
                'icons' => null,
                'map' => null,
                'path' => null,
                'strokeColor' => null,
                'strokeOpacity' => null,
                'strokeWeight' => null,
                'visible' => null,
                'zIndex' => null,
            ],
            $this->options
        );

        parent::__construct($config);
    }

    /**
     * Sets the map name option attribute.
     *
     * @param string $value
     */
    public function setMap($value)
    {
        $this->options['map'] = new JsExpression($value);
    }

    /**
     * Sets the content of the infoWindow object. It has support to get the content from a DOM node.
     *
     * @param string $value
     */
    public function setContent($value)
    {
        if (strpos(strtolower($value), 'getelementbyid') > 0) {
            $this->options['content'] = new JsExpression($value);
        } else {
            $value = preg_replace('/\r\n|\n|\r/', "\\n", $value);
            $value = preg_replace('/(["\'])/', '\\\\\1', $value);

            $this->options['content'] = $value;
        }
    }

    /**
     * Sets the pixelOffset to ensure its type
     *
     * @param Size $pixelOffset
     */
    public function setPixelOffset(Size $pixelOffset)
    {
        $this->options['pixelOffset'] = $pixelOffset;
    }

    /**
     *
     * Sets the position of the infoWindow to ensure its type
     *
     * @param LatLng $position
     */
    public function setPosition(LatLng $position)
    {
        $this->options['position'] = $position;
    }
} 