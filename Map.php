<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps;

use dosamigos\google\maps\overlays\Marker;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\ArrayHelper;

/**
 * Map
 *
 * @property string backgroundColor Color used for the background of the Map div. This color will be visible
 * when tiles have not yet loaded as the user pans. This option can only be set when the map is initialized.
 * @property LatLng center The initial Map center. Required.
 * @property boolean disableDefaultUI Enables/disables all default UI. May be overridden individually.
 * @property boolean disableDoubleClickZoom Enables/disables zoom and center on double click. Enabled by default.
 * @property boolean draggable If false, prevents the map from being dragged. Dragging is enabled by default.
 * @property string draggableCursor The name or url of the cursor to display when mousing over a draggable map.
 * This property uses the css cursor attribute to change the icon. As with the css property, you must specify at least
 * one fallback cursor that is not a URL. For example: draggableCursor: 'url(http://www.example.com/icon.png), auto;'.
 * @property string draggingCursor The name or url of the cursor to display when the map is being dragged. This property
 * uses the css cursor attribute to change the icon. As with the css property, you must specify at least one fallback
 * cursor that is not a URL. For example: draggingCursor: 'url(http://www.example.com/icon.png), auto;'.
 * @property int heading The heading for aerial imagery in degrees measured clockwise from cardinal direction North.
 * Headings are snapped to the nearest available angle for which imagery is available.
 * @property boolean keyboardShortcuts If false, prevents the map from being controlled by the keyboard. Keyboard
 * shortcuts are enabled by default.
 * @property boolean mapMaker True if Map Maker tiles should be used instead of regular tiles.
 * @property boolean mapTypeControl The initial enabled/disabled state of the Map type control.
 * @property [\doamigos\maps\controls\MapTypeControlOptions] mapTypeControlOptions The initial display options for the
 * Map type control.
 * @property string mapTypeId The initial Map mapTypeId. Defaults to [MapTypeId::ROADMAP].
 * @property int maxZoom The maximum zoom level which will be displayed on the map. If omitted, or set to null,
 * the maximum zoom from the current map type is used instead.
 * @property int minZoom The minimum zoom level which will be displayed on the map. If omitted, or set to null,
 * the minimum zoom from the current map type is used instead.
 * @property boolean noClearIf true, do not clear the contents of the Map div.
 * @property boolean overviewMapControlThe enabled/disabled state of the Overview Map control.
 * @property [\doamigos\maps\controls\OverViewMapControlOptions] overviewMapControlOptions The display options for the
 * Overview Map control.
 * @property boolean panControlThe enabled/disabled state of the Pan control.
 * @property[\doamigos\maps\controls\PanControlOptions] panControlOptions The display options for the Pan control.
 * @property boolean rotateControlThe enabled/disabled state of the Rotate control.
 * @property RotateControlOptions rotateControlOptions The display options for the Rotate control.
 * @property boolean scaleControlThe initial enabled/disabled state of the Scale control.
 * @property [\doamigos\maps\controls\ScaleControlOptions] scaleControlOptions The initial display
 * options for the Scale control.
 * @property boolean scrollwheel If false, disables scrollwheel zooming on the map. The scrollwheel is enabled by
 * default.
 * @property [\doamigos\maps\services\StreetViewPanorama] streetView A StreetViewPanorama to display when the Street
 * View pegman is dropped on
 * the map. If no panorama is specified, a default StreetViewPanorama will be displayed in the map's div when the pegman
 * is dropped.
 * @property boolean streetViewControlThe initial enabled/disabled state of the Street View Pegman control. This control
 * is part of the default UI, and should be set to false when displaying a map type on which the Street View road overlay
 * should not appear (e.g. a non-Earth map type).
 * @property [\doamigos\maps\controls\StreetViewControlOptions] streetViewControlOptions The initial display options
 * for the Street View Pegman control.
 * @property array styles Styles to apply to each of the default map types. Note that for Satellite/Hybrid and Terrain
 * modes, these styles will only apply to labels and geometry.
 * @property int tilt Controls the automatic switching behavior for the angle of incidence of the map. The only allowed
 * values are 0 and 45. The value 0 causes the map to always use a 0° overhead view regardless of the zoom level and
 * viewport. The value 45 causes the tilt angle to automatically switch to 45 whenever 45° imagery is available for the
 * current zoom level and viewport, and switch back to 0 whenever 45° imagery is not available (this is the default
 * behavior). 45° imagery is only available for SATELLITE and HYBRID map types, within some locations, and at some zoom
 * levels. Note: getTilt returns the current tilt angle, not the value specified by this option. Because getTilt and
 * this option refer to different things, do not bind() the tilt property; doing so may yield unpredictable effects.
 * @property int zoom The initial Map zoom level. Required.
 * @property boolean zoomControlThe enabled/disabled state of the Zoom control.
 * @property [\doamigos\maps\controls\ZoomControlOptions] zoomControlOptions The display options for the Zoom control.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class Map extends ObjectAbstract
{
    /**
     * @var int the width in pixels or percent of the container holding the map.
     */
    public $width = 512;
    /**
     * @var int the height in pixels or percent of the container holding the map.
     */
    public $height = 512;
    /**
     * @var array the HTML attributes for the layer that will render the map.
     */
    public $containerOptions = [];
    /**
     * @var array stores the overlays that are going to be rendered on the map.
     */
    private $_overlays = [];
    /**
     * @var array stores closure scope variables. Global to the js module written.
     */
    private $_closure_scope_variables = [];
    /**
     * @var array stores javascript code that is going to be rendered together with script initialization
     */
    private $_js = [];
    /**
     * @var PluginManager that manages the active plugins activated for the map.
     */
    private $_plugins;

    /**
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->options = ArrayHelper::merge(
            [
                'backgroundColor' => null,
                'center' => null,
                'disableDefaultUI' => null,
                'disableDoubleClickZoom' => null,
                'draggable' => null,
                'draggableCursor' => null,
                'draggingCursor' => null,
                'heading' => null,
                'keyboardShortcuts' => null,
                'mapMaker' => null,
                'mapTypeControl' => null,
                'mapTypeControlOptions' => null,
                'mapTypeId' => null,
                'maxZoom' => null,
                'minZoom' => null,
                'noClear' => null,
                'overviewMapControl' => null,
                'overviewMapControlOptions' => null,
                'panControl' => null,
                'panControlOptions' => null,
                'rotateControl' => null,
                'rotateControlOptions' => null,
                'scaleControl' => null,
                'scaleControlOptions' => null,
                'scrollwheel' => null,
                'streetView' => null,
                'streetViewControl' => null,
                'streetViewControlOptions' => null,
                'styles' => null,
                'tilt' => null,
                'zoom' => null,
                'zoomControl' => null,
                'zoomControlOptions' => null,
            ],
            $this->options
        );
        parent::__construct($config);
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if ($this->center == null || $this->zoom == null) {
            throw new InvalidConfigException('"center", "zoom" and/or "divId" cannot be null');
        }

        $this->_plugins = new PluginManager();
    }

    /**
     * @param $overlay
     *
     * @return $this
     */
    public function addOverlay($overlay)
    {
        $this->_overlays[] = $overlay;
        return $this;
    }

    /**
     * @return array
     */
    public function getOverlays()
    {
        return $this->_overlays;
    }

    /**
     * @param int $margin
     * @param int $default
     *
     * @return int
     */
    public function getMarkersFittingZoom($margin = 0, $default = 14)
    {
        $markers = $this->getMarkers();
        $bounds = LatLngBounds::getBoundsOfMarkers($markers, $margin);

        return $bounds->getZoom(min($this->width, $this->height), $default);

    }

    /**
     * @return LatLng|null
     */
    public function getMarkersCenterCoordinates()
    {
        return Marker::getCenterOfMarkers($this->getMarkers());
    }

    /**
     * @return string
     */
    public function getMarkersForUrl()
    {
        $coords = [];
        foreach ($this->getMarkers() as $marker) {
            /** @var Marker $marker */
            $coords[] = $marker->getMarkerStatic();
        }

        return implode("|", $coords);
    }


    /**
     * @return array
     */
    public function getMarkers()
    {
        $markers = [];
        foreach ($this->getOverlays() as $overlay) {
            if ($overlay instanceof Marker) {
                $markers[] = $overlay;
            }
        }
        return $markers;
    }

    /**
     * @return LatLngBounds
     */
    public function getBoundsFromCenterAndZoom()
    {
        return LatLngBounds::getBoundsFromCenterAndZoom($this->center, $this->zoom, $this->width, $this->height);
    }

    /**
     * @param LatLng $coord
     */
    public function setCenter(LatLng $coord)
    {
        $this->options['center'] = $coord;
    }

    /**
     * @return mixed
     */
    public function getCenter()
    {
        return ArrayHelper::getValue($this->options, 'center');
    }

    /**
     * @param $name
     * @param null $value
     */
    public function setClosureScopedVariable($name, $value = null)
    {
        $this->_closure_scope_variables[$name] = $value;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getClosureScopedVariable($name)
    {
        return ArrayHelper::getValue($this->_closure_scope_variables, $name);
    }

    /**
     * @return array
     */
    public function getClosureScopedVariables()
    {
        return $this->_closure_scope_variables;
    }

    /**
     * @return string
     */
    protected function getClosureScopedVariablesScript()
    {
        $js = [];
        foreach ($this->getClosureScopedVariables() as $name => $value) {
            if ($value !== null) {
                if (!($value instanceof JsExpression) && strpos('{', $value) !== false) {
                    $value = is_string($value) ? "'$value'" : $value;
                }
                $value = " = {$value}";
            }
            $js[] = "var {$name}{$value};";
        }
        return implode("\n", $js);
    }

    /**
     * @param string $maptype
     * @param string $hl
     *
     * @return string
     */
    public function getStaticMapUrl($maptype = 'mobile', $hl = 'es')
    {
        $params = [
            'maptype' => $maptype,
            'zoom' => $this->zoom,
            'key' => @Yii::$app->params['googleMapsApiKey'] ? : null,
            'center' => $this->center,
            'size' => $this->width . 'x' . $this->height,
            'hl' => $hl,
            'markers' => $this->getMarkersForUrl()
        ];

        $params = http_build_query($params);

        return 'http://maps.google.com/staticmap?' . $params;
    }

    /**
     * @return string
     */
    public function display()
    {
        $this->registerClientScript();

        return $this->renderContainer();
    }

    /**
     * @return string
     */
    public function renderContainer()
    {
        $this->containerOptions['id'] = ArrayHelper::getValue(
            $this->containerOptions,
            'id',
            $this->getName() . '-map-canvas'
        );

        return Html::tag('div', '', $this->containerOptions);
    }

    /**
     * @param int $position
     */
    public function registerClientScript($position = View::POS_END)
    {
        $view = Yii::$app->getView();
        MapAsset::register($view);

        $view->registerJs($this->getJs(), $position);
    }

    /**
     * @param $js
     *
     * @return $this
     */
    public function appendScript($js)
    {
        $this->_js[] = $js;

        return $this;
    }

    /**
     * @return string
     */
    public function getJs()
    {
        $name = $this->getName();
        $width = strpos($this->width, "%") ? $this->width : $this->width . 'px';
        $height = strpos($this->height, "%") ? $this->height : $this->height . 'px';
        $containerId = ArrayHelper::getValue($this->containerOptions, 'id', $name . '-map-canvas');
        $overlaysJs = [];
        $js = [];
        foreach ($this->getOverlays() as $overlay) {
            /** @var ObjectAbstract $overlay */
            if (!ArrayHelper::keyExists("{$name}infoWindow", $this->getClosureScopedVariables()) &&
                method_exists($overlay, 'getIsInfoWindowShared')
                && $overlay->getIsInfoWindowShared()
            ) {
                $this->setClosureScopedVariable("{$name}infoWindow");
                $this->appendScript("{$name}infoWindow = new google.maps.InfoWindow();");
            }
            $overlay->options['map'] = new JsExpression($this->getName());
            $overlaysJs[] = $overlay->getJs();
        }
        $js[] = "(function(){";
        $js[] = $this->getClosureScopedVariablesScript();
        $js[] = "function initialize(){";
        $js[] = "var mapOptions = {$this->getEncodedOptions()};";
        $js[] = "var container = document.getElementById('{$containerId}');";
        $js[] = "container.style.width = '{$width}';";
        $js[] = "container.style.height = '{$height}';";
        $js[] = "var {$this->getName()} = new google.maps.Map(container, mapOptions);";
        $js = ArrayHelper::merge($js, $overlaysJs);
        foreach ($this->events as $event) {
            /** @var Event $event */
            $js[] = $event->getJs($name);
        }

        foreach ($this->getPlugins()->getInstalledPlugins() as $plugin) {
            /** @var \dosamigos\google\maps\PluginAbstract $plugin */
            $plugin->map = $this->getName();
            $js[] = $plugin->getJs($name);
        }

        $js = ArrayHelper::merge($js, $this->_js);
        $js[] = "};";
        $js[] = "initialize();";
        $js[] = "})();";

        return implode("\n", $js);
    }

    /**
     * @return PluginManager
     */
    public function getPlugins()
    {
        return $this->_plugins;
    }

    /**
     * Installs a plugin
     *
     * @param PluginAbstract $plugin
     */
    public function installPlugin(PluginAbstract $plugin)
    {
        $this->getPlugins()->install($plugin);
    }

    /**
     * Removes an installed plugin
     *
     * @param $plugin
     *
     * @return mixed|null
     */
    public function removePlugin($plugin)
    {
        return $this->getPlugins()->remove($plugin);
    }
} 
