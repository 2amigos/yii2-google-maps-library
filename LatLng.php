<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps;

use yii\base\InvalidParamException;

/**
 * LatLng
 *
 * Google maps LatLng object
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class LatLng extends ObjectAbstract
{
    /**
     * @var float latitude
     */
    private $_lat;
    /**
     * @var float longitude
     */
    private $_lng;
    /**
     * @var bool set to true to enable values outside of this range.
     */
    public $noWrap = false;

    /**
     * @return float the latitude
     */
    public function getLat()
    {
        return $this->_lat;
    }

    /**
     * @param float $value sets the latitude
     */
    public function setLat($value)
    {
        $this->_lat = floatval($value);
    }

    /**
     * @return float the longitude
     */
    public function getLng()
    {
        return $this->_lng;
    }

    /**
     * @param float $value sets the longitude
     */
    public function setLng($value)
    {
        $this->_lng = floatval($value);
    }

    /**
     * @return string the js constructor of the object
     */
    public function getJs()
    {
        $noWrap = $this->noWrap ? ', true' : '';
        $name = $this->getName(false) ? "var {$this->getName()} = " : "";
        return "{$name}new google.maps.LatLng({$this->__toString()}{$noWrap})";
    }

    /**
     * Very approximate calculation of the distance in kilometers between two coordinates
     *
     * @param LatLng $coord
     *
     * @return float
     */
    public function distanceFrom(LatLng $coord)
    {
        $latDist = abs($this->getLat() - $coord->getLat());
        $lngDist = abs($this->getLng() - $coord->getLng());

        $radDist = deg2rad(sqrt(pow($latDist, 2) + pow($lngDist, 2)));

        return $radDist * UnitsType::EARTH_RADIUS;
    }

    /**
     * Exact distance with spherical law of cosines
     *
     * @param LatLng $coord
     * @param string $unit the unit to return
     *
     * @return float
     * @see http://www.geodatasource.com/developers/php
     */
    public function exactDistanceSLCFrom(LatLng $coord, $unit = UnitsType::KILOMETERS)
    {
        $lat1 = $this->getLat();
        $lat2 = $coord->getLat();
        $lon1 = $this->getLng();
        $lon2 = $coord->getLng();

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(
                deg2rad($theta)
            );
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        switch ($unit) {
            case UnitsType::KILOMETERS:
                $distance = $miles * 1.609344;
                break;
            case UnitsType::NAUTIC_MILES:
                $distance = $miles * 0.8684;
                break;
            case UnitsType::MILES:
            default:
                $distance = $miles;
        }
        return $distance;
    }

    /**
     * Returns true if coordinate is within bounds
     *
     * @param LatLngBounds $bounds
     *
     * @return bool whether is inside of boundaries or not
     */
    public function isInBounds(LatLngBounds $bounds)
    {

        return $bounds->containsCoordinate($this);
    }

    /**
     * Exact distance with Haversine formula
     *
     * @param LatLng $coord
     *
     * @return float
     * @see http://www.movable-type.co.uk/scripts/latlong.html
     */
    public function exactDistanceFrom(LatLng $coord)
    {
        $lat1 = deg2rad($this->getLat());
        $lat2 = deg2rad($coord->getLat());
        $lon1 = deg2rad($this->getLng());
        $lon2 = deg2rad($coord->getLng());

        $dLatHalf = ($lat2 - $lat1) / 2;
        $dLonHalf = ($lon2 - $lon1) / 2;

        $a = pow(sin($dLatHalf), 2) + cos($lat1) * cos($lat2) * pow(sin($dLonHalf), 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $c * UnitsType::EARTH_RADIUS;
    }

    /**
     * @return string the latitude and longitude
     */
    public function __toString()
    {
        $lat = number_format($this->getLat(), 10, '.', '');
        $lng = number_format($this->getLng(), 10, '.', '');
        return "$lat, $lng";
    }

    /**
     * Creates a LatLng object from a string. For example:
     *
     * ```
     * $coord = LatLng::createFromString('-3.89,3.22');
     * ```
     *
     * @param string $value
     *
     * @return LatLng|null
     */
    public static function createFromString($value)
    {
        $coord = explode(',', $value);
        if (count($coord) == 2) {
            $lat = floatval(trim($coord[0]));
            $lng = floatval(trim($coord[1]));
            return new self([
                'lat' => $lat,
                'lng' => $lng
            ]);
        }
        return null;
    }

    /**
     * Converts longitude to pixels a World's according to Google
     * http://mt0.google.com/mt/v=ap.92&hl=en&x=0&y=0&z=0&s=
     *
     * @param float $lng
     * @param int $zoom
     *
     * @return float the pixels
     */
    public static function lngToPixels($lng, $zoom)
    {
        $lngRad = deg2rad($lng);
        $mercX = $lngRad;
        $cartX = $mercX + pi();
        $pixelX = $cartX * 256 / (2 * pi());
        $pixelXZoom = $pixelX * pow(2, $zoom);

        return $pixelXZoom;
    }

    /**
     * Converts latitude to pixels a World's according to Google
     * http://mt0.google.com/mt/v=ap.92&hl=en&x=0&y=0&z=0&s=
     *
     * @param float $lat
     * @param int $zoom
     *
     * @return int|mixed the pixels
     */
    public static function latToPixels($lat, $zoom)
    {
        if ($lat == 90) {
            $pixelY = 0;
        } else if ($lat == -90) {
            $pixelY = 256;
        } else {
            $latRad = deg2rad($lat);
            $mercY = log(tan(pi() / 4 + $latRad / 2));
            $cartY = pi() - $mercY;
            $pixelY = $cartY * 256 / 2 / pi();
            $pixelY = max(0, $pixelY); // correct rounding errors near north and south poles
            $pixelY = min(256, $pixelY); // correct rounding errors near north and south poles
        }
        $pixelYZoom = $pixelY * pow(2, $zoom);

        return $pixelYZoom;
    }


    /**
     * Converts pixels to longitude on a World's map according to Google
     * http://mt0.google.com/mt/v=ap.92&hl=en&x=0&y=0&z=0&s=
     *
     * @param int $pixelXZoom
     * @param int $zoom
     *
     * @return float the longitude
     */
    public static function pixelsToLng($pixelXZoom, $zoom)
    {
        $pixelX = $pixelXZoom / pow(2, $zoom);
        $cartX = $pixelX / 256 * 2 * pi();
        $mercX = $cartX - pi();
        $lngRad = $mercX;
        $lng = rad2deg($lngRad);

        return $lng;
    }

    /**
     * Converts pixels to latitude coord on a World's map according to Google
     * http://mt0.google.com/mt/v=ap.92&hl=en&x=0&y=0&z=0&s=
     *
     * @param int $pixelYZoom
     * @param int $zoom
     *
     * @return float|int
     */
    public static function pixelsToLat($pixelYZoom, $zoom)
    {
        $pixelY = $pixelYZoom / pow(2, $zoom);
        if ($pixelY == 0) {
            $lat = 90;
        } else if ($pixelY == 256) {
            $lat = -90;
        } else {
            $cartY = $pixelY / 256 * 2 * pi();
            $mercY = pi() - $cartY;
            $latRad = 2 * atan(exp($mercY)) - pi() / 2;
            $lat = rad2deg($latRad);
        }

        return $lat;
    }

    /**
     * Calculates the center of an array of coordinates
     *
     * @param LatLng[] $coords
     *
     * @return LatLng|null
     * @throws \yii\base\InvalidParamException
     */
    public static function getCenterOfCoordinates($coords)
    {
        $cnt = count($coords);
        if ($cnt == 0) {
            return null;
        }

        $centerLat = $centerLng = 0;

        foreach ($coords as $coord) {
            if (!($coord instanceof LatLng)) {
                throw new InvalidParamException('$coord must be an array of "' . self::className() . '" objects');
            }
            $centerLat += $coord->getLat();
            $centerLng += $coord->getLng();
        }

        return new self([
            'lat' => ($centerLat / $cnt),
            'lng' => ($centerLng / $cnt)
        ]);
    }

    /**
     * Calculates the center of an array of coordinates according to its bounds
     *
     * @param LatLng[] $coords
     *
     * @return LatLng
     */
    public static function getCenterOfBounds($coords)
    {
        $bounds = LatLngBounds::getBoundsOfCoordinates($coords);

        return $bounds->getCenterCoordinates();
    }
} 