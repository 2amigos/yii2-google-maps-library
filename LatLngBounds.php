<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps;


use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\overlays\Polygon;
use yii\base\InvalidParamException;
use yii\base\Object;
use yii\helpers\ArrayHelper;

/**
 * LatLngBounds
 *
 * Google maps bounds object
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class LatLngBounds extends Object
{
    /**
     * @var LatLng|null South West coordinate
     */
    private $_sw = null;
    /**
     * @var null|LatLng North East coordinate
     */
    private $_ne = null;


    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->_ne)) {
            $this->setNorthEast(new LatLng());
        }
        if (empty($this->_sw)) {
            $this->setSouthWest(new LatLng());
        }
    }

    /**
     *
     * @return LatLng object
     */
    public function getNorthEast()
    {
        return $this->_ne;
    }

    /**
     * Sets the North East coordinate
     * @param LatLng $value
     */
    public function setNorthEast(LatLng $value)
    {
        $this->_ne = $value;
    }

    /**
     *
     * @return LatLng object
     */
    public function getSouthWest()
    {
        return $this->_sw;
    }

    /**
     * Sets the South West coordinate
     * @param LatLng $value
     */
    public function setSouthWest(LatLng $value)
    {
        $this->_sw = $value;
    }

    /**
     * @return string the js constructor of the object
     */
    public function getJs()
    {
        $sw = $this->getSouthWest()->getJs();
        $ne = $this->getNorthEast()->getJs();

        return "new google.maps.LatLngBounds($sw, $ne)";
    }

    /**
     * Get the latitude of the center of the zone
     * @return integer
     */
    public function getCenterLat()
    {
        return (is_null($this->getSouthWest()) || is_null($this->getNorthEast()))
            ? null
            : floatval(($this->getSouthWest()->getLat() + $this->getNorthEast()->getLat()) / 2);
    }

    /**
     * Get the longitude of the center of the zone
     * @return integer
     */
    public function getCenterLng()
    {
        return (is_null($this->getSouthWest()) || is_null($this->getNorthEast()))
            ? null
            : floatval(($this->getSouthWest()->getLng() + $this->getNorthEast()->getLng()) / 2);
    }

    /**
     * Get the coordinates of the center of the zone
     * @return LatLng
     */
    public function getCenterCoordinates()
    {

        return new LatLng(['lat' => $this->getCenterLat(), 'lng' => $this->getCenterLng()]);
    }

    /**
     * Returns the height of boundaries zone
     * @return float
     */
    public function getHeight()
    {
        return abs($this->getNorthEast()->getLat() - $this->getSouthWest()->getLat());
    }

    /**
     * Returns the width of boundaries zone
     * @return float
     */
    public function getWidth()
    {
        return abs($this->getNorthEast()->getLng() - $this->getSouthWest()->getLng());
    }

    /**
     * Does a homothety transformation on the bounds, centered on the center of the bounds
     *
     * @param float $factor
     * @return LatLngBounds $bounds
     */
    public function getHomothety($factor)
    {
        $bounds = new LatLngBounds();
        $lat = $this->getCenterLat();
        $lng = $this->getCenterLng();
        $bounds->getNorthEast()->setLat($factor * $this->getNorthEast()->getLat() + $lat * (1 - $factor));
        $bounds->getSouthWest()->setLat($factor * $this->getSouthWest()->getLat() + $lat * (1 - $factor));
        $bounds->getNorthEast()->setLng($factor * $this->getNorthEast()->getLng() + $lng * (1 - $factor));
        $bounds->getSouthWest()->setLng($factor * $this->getSouthWest()->getLng() + $lng * (1 - $factor));

        return $bounds;
    }

    /**
     * Returns zoomed out bounds
     *
     * @param int $zoomCoeficient
     * @return LatLngBounds
     */
    public function getZoomOut($zoomCoeficient)
    {
        if ($zoomCoeficient > 0) {
            $bounds = $this->getHomothety(pow(2, $zoomCoeficient));
            return $bounds;
        }
        return $this;
    }

    /**
     * Returns the most appropriate zoom to see the bounds on a map with min(width, height) = $minWidthHeight.
     *
     * @param int $minWidthHeight width or height of the map in pixels
     * @param int $default the defaults zoom
     * @return integer
     */
    public function getZoom($minWidthHeight, $default = 14)
    {
        $infinity = 999999999;
        $heightFactor = $infinity;
        $widthFactor = $infinity;

        /*
          formula: the width of the bounds in "pixels" is $pixW * 2^z
          We want $pixW * 2^z to fit in $minWidthHeight so we are looking for
          z = round ( log2 ( $minWidthHeight / $pixW  ) )
         */

        $swLatPix = LatLng::latToPixels($this->getSouthWest()->getLat(), 0);
        $neLatPix = LatLng::latToPixels($this->getNorthEast()->getLat(), 0);
        $pixH = abs($swLatPix - $neLatPix);
        if ($pixH > 0) {
            $heightFactor = $minWidthHeight / $pixH;
        }

        $swLngPix = LatLng::lngToPixels($this->getSouthWest()->getLng(), 0);
        $neLngPix = LatLng::lngToPixels($this->getNorthEast()->getLng(), 0);
        $pixW = abs($swLngPix - $neLngPix);
        if ($pixW > 0) {
            $widthFactor = $minWidthHeight / $pixW;
        }

        $factor = min($widthFactor, $heightFactor);

        // bounds is one point, no zoom can be determined
        if ($factor == $infinity) {
            return $default;
        }

        return round(log($factor, 2));
    }

    /**
     *
     * @param LatLng $coord
     * @return boolean true if the coordinate is inside boundaries
     */
    public function containsCoordinate(LatLng $coord)
    {
        return (
            $coord->getLat() < $this->getNorthEast()->getLat()
            &&
            $coord->getLat() > $this->getSouthWest()->getLat()
            &&
            $coord->getLng() < $this->getNorthEast()->getLng()
            &&
            $coord->getLng() > $this->getSouthWest()->getLng()
        );
    }

    /**
     * Google String representations
     * @return string
     */
    public function __toString()
    {
        return '((' . $this->getSouthWest()->getLat() . ', ' . $this->getSouthWest()->getLng() . '), ' .
        '(' . $this->getNorthEast()->getLat() . ', ' . $this->getNorthEast()->getLng() . '))';
    }

    /**
     * Creates a LatLngBounds object from a string representation of ((Lat, Lng), (Lat, Lng)) values. For example:
     *
     * ```
     *  ((48.82415805606007,2.308330535888672),(48.867086142850226,2.376995086669922))
     * ```
     *
     * @param string $string the coordinates representation of boundaries
     * @return LatLngBounds|null
     */
    public static function createFromString($string)
    {
        preg_match('/\(\((.*?)\), \((.*?)\)\)/', $string, $matches);
        if (count($matches) == 3) {
            $sw = LatLng::createFromString($matches[1]);
            $ne = LatLng::createFromString($matches[2]);
            if (!is_null($sw) && !is_null($ne)) {
                return new self(['southWest' => $sw, 'northEast' => $ne]);
            }
        }
        return null;
    }

    /**
     * Returns the boundaries of an array of Bound objects
     *
     * @param LatLngBounds[] $boundaries
     * @param float $margin
     * @return LatLngBounds
     * @throws \yii\base\InvalidParamException
     */
    public static function getBoundsOfBounds($boundaries, $margin = 0.0)
    {
        $minLat = 1000;
        $maxLat = -1000;
        $minLng = 1000;
        $maxLng = -1000;
        foreach ($boundaries as $bounds) {
            if (!($bounds instanceof LatLngBounds)) {
                throw new InvalidParamException('"$boundaries" must be an array of "' . self::className() . '" objects');
            }
            $minLat = min($minLat, $bounds->getSouthWest()->getLat());
            $minLng = min($minLng, $bounds->getSouthWest()->getLng());
            $maxLat = max($maxLat, $bounds->getNorthEast()->getLat());
            $maxLng = max($maxLng, $bounds->getNorthEast()->getLng());
        }

        if ($margin > 0) {
            $minLat = $minLat - $margin * ($maxLat - $minLat);
            $minLng = $minLng - $margin * ($maxLng - $minLng);
            $maxLat = $maxLat + $margin * ($maxLat - $minLat);
            $maxLng = $maxLng + $margin * ($maxLng - $minLng);
        }

        return new self([
                'southWest' => new LatLng(['lat' => $minLat, 'lng' => $minLng]),
                'northEast' => new LatLng(['lat' => $maxLat, 'lng' => $maxLng])]
        );

    }

    /**
     * Returns the boundaries of an array of LatLng objects
     * @param LatLng[] $coords
     * @param float $margin
     * @return LatLngBounds
     * @throws \yii\base\InvalidParamException
     */
    public static function getBoundsOfCoordinates($coords, $margin = 0.0)
    {
        $minLat = 1000;
        $maxLat = -1000;
        $minLng = 1000;
        $maxLng = -1000;
        foreach ($coords as $coord) {
            if (!($coord instanceof LatLng)) {
                throw new InvalidParamException('$coords must be an array of "' . LatLng::className() . '" objects');
            }
            /* @var $coord LatLng */
            $minLat = min($minLat, $coord->getLat());
            $maxLat = max($maxLat, $coord->getLat());
            $minLng = min($minLng, $coord->getLng());
            $maxLng = max($maxLng, $coord->getLng());
        }

        if ($margin > 0) {
            $minLat = $minLat - $margin * ($maxLat - $minLat);
            $minLng = $minLng - $margin * ($maxLng - $minLng);
            $maxLat = $maxLat + $margin * ($maxLat - $minLat);
            $maxLng = $maxLng + $margin * ($maxLng - $minLng);
        }
        return new self([
            'southWest' => new LatLng(['lat' => $minLat, 'lng' => $minLng]),
            'northEast' => new LatLng(['lat' => $maxLat, 'lng' => $maxLng])
        ]);
    }

    /**
     * Returns the boundaries of an array of Marker objects
     * @param Marker[] $markers
     * @param float $margin
     * @return LatLngBounds
     * @throws \yii\base\InvalidParamException
     */
    public static function getBoundsOfMarkers($markers, $margin = 0.0)
    {
        $coords = [];
        foreach ($markers as $marker) {
            if (!($marker instanceof Marker)) {
                throw new InvalidParamException('"$markers" must be an array of "' . Marker::className() . '" objects');
            }
            $coords[] = $marker->position;
        }

        return LatLngBounds::getBoundsOfCoordinates($coords, $margin);
    }

    /**
     * Returns the boundaries of an array of Polygon objects
     * @param Polygon[] $polygons array of Polygons
     * @param float $margin margin factor for the bounds
     * @return LatLngBounds
     * @throws \yii\base\InvalidParamException
     */
    public static function getBoundsOfPolygons($polygons, $margin = 0.0)
    {
        $coords = [];
        /** @var Polygon $polygon */
        foreach ($polygons as $polygon) {
            if (!($polygon instanceof Polygon)) {
                throw new InvalidParamException('"$polygons" must be an array of "' . Polygon::className() . '" objects');
            }
            // merge LatLng arrays
            $coords = ArrayHelper::merge($coords, $polygon->paths);
        }

        return LatLngBounds::getBoundsOfCoordinates($coords, $margin);
    }

    /**
     * Calculate the bounds corresponding to a specific center and zoom level for a give map size in pixels
     * @param LatLng $center
     * @param integer $zoom
     * @param integer $width
     * @param integer $height
     * @return LatLngBounds
     */
    public static function getBoundsFromCenterAndZoom(LatLng $center, $zoom, $width, $height = null)
    {
        if (is_null($height)) {
            $height = $width;
        }

        $centerLat = $center->getLat();
        $centerLng = $center->getLng();

        $pix = LatLng::latToPixels($centerLat, $zoom);
        $neLat = LatLng::pixelsToLat($pix - round(($height - 1) / 2), $zoom);
        $swLat = LatLng::pixelsToLat($pix + round(($height - 1) / 2), $zoom);

        $pix = LatLng::lngToPixels($centerLng, $zoom);
        $swLng = LatLng::pixelsToLng($pix - round(($width - 1) / 2), $zoom);
        $neLng = LatLng::pixelsToLng($pix + round(($width - 1) / 2), $zoom);

        return new self([
            'southWest' => new LatLng(['lat' => $swLat, 'lng' => $swLng]),
            'northEast' => new LatLng(['lat' => $neLat, 'lng' => $neLng])
        ]);
    }
} 