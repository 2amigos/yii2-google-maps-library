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
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * PolygonOptions
 *
 * Eases the configuration of a polygon or polygons
 *
 * @property boolean clickable Indicates whether this Polygon handles mouse events. Defaults to true.
 * @property boolean draggable If set to true, the user can drag this shape over the map. The geodesic property defines
 * the mode of dragging. Defaults to false.
 * @property boolean editable If set to true, the user can edit this shape by dragging the control points shown at the
 * vertices and on each segment. Defaults to false.
 * @property string fillColor The fill color. All CSS3 colors are supported except for extended named colors.
 * @property int fillOpacity The fill opacity between 0.0 and 1.0
 * @property boolean geodesic When true, edges of the polygon are interpreted as geodesic and will follow the curvature
 * of the Earth. When false, edges of the polygon are rendered as straight lines in screen space. Note that the shape
 * of a geodesic polygon may appear to change when dragged, as the dimensions are maintained relative to the surface of
 * the earth. Defaults to false.
 * @property string map Map name on which to display Polygon.
 * @property LatLng[] paths The ordered sequence of coordinates that designates a closed loop. Unlike polylines, a
 * polygon may consist of one or more paths. As a result, the paths property may specify one or more arrays of LatLng
 * coordinates. Paths are closed automatically; do not repeat the first vertex of the path as the last vertex. Simple
 * polygons may be defined using a single array of LatLngs. More complex polygons may specify an array of arrays. Any
 * simple arrays are converted into MVCArrays. Inserting or removing LatLngs from the MVCArray will automatically update
 * the polygon on the map.
 * @propperty string strokeColor The stroke color. All CSS3 colors are supported except for extended named colors.
 * @property int strokeOpacity The stroke opacity between 0.0 and 1.0
 * @property string strokePosition The stroke position. Defaults to [StrokePosition::CENTER]. This property is not
 * supported on Internet Explorer 8 and earlier.
 * @property int strokeWeight The stroke width in pixels.
 * @property boolean visible Whether this polygon is visible on the map. Defaults to true.
 * @property int zIndex The zIndex compared to other polygones.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class PolygonOptions extends ObjectAbstract
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
                'fillColor' => null,
                'fillOpacity' => null,
                'geodesic' => null,
                'map' => null,
                'paths' => [],
                'strokeColor' => null,
                'strokeOpacity' => null,
                'strokePosition' => null,
                'strokeWeight' => null,
                'visible' => null,
                'zIndex' => null,
            ],
            $this->options
        );

        parent::__construct($config);
    }

    /**
     * Sets the map option property.
     *
     * @param string $value
     */
    public function setMap($value)
    {
        $this->options['map'] = new JsExpression($value);
    }

    /**
     * Adds a coordinate to the path array
     *
     * @param LatLng $coord
     *
     * @return $this
     */
    public function addCoord(LatLng $coord)
    {
        $cloned = clone $coord;
        $cloned->name = null;
        $this->options['paths'][] = $coord;

        return $this;
    }

    /**
     * Sets the path of the polygon
     *
     * @param array $coords
     */
    public function setPaths(array $coords)
    {
        foreach ($coords as $coord) {
            $this->addCoord($coord);
        }
    }
} 