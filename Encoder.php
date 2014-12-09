<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps;

/**
 * Encoder
 *
 * Encodes paths of polylines. Based on Mark McClure's Javascript PolylineEncoder
 * Jim Hribar's PHP version and Matthias Bauer PHP class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class Encoder
{
    private $numLevels = 18;
    private $zoomFactor = 2;
    private $verySmall = 0.00001;
    private $forceEndpoints = true;
    private $zoomLevelBreaks = array();

    /**
     * All parameters are set with useful defaults.
     * If you actually want to understand them, see Mark McClure's detailed description.
     *
     * @see    http://facstaff.unca.edu/mcmcclur/GoogleMaps/EncodePolyline/algorithm.html
     */
    public function __construct($numLevels = 18, $zoomFactor = 2, $verySmall = 0.00001, $forceEndpoints = true)
    {
        $this->numLevels = $numLevels;
        $this->zoomFactor = $zoomFactor;
        $this->verySmall = $verySmall;
        $this->forceEndpoints = $forceEndpoints;

        for ($i = 0; $i < $this->numLevels; $i++) {
            $this->zoomLevelBreaks[$i] = $this->verySmall * pow($this->zoomFactor, $this->numLevels - $i - 1);
        }
    }

    /**
     * Generates all values needed for the encoded Google Maps [\dosamigos\google\maps\overlays\Polyline].
     *
     * @param array $points Multidimensional input array of [\dosamigos\google\maps\Point] elements
     *
     * @return stdClass    Simple object containing three public parameter:
     *                    - points: the points string with escaped backslashes
     *          - levels: the encoded levels ready to use
     *          - rawPoints: the points right out of the encoder
     *          - numLevels: should be used for creating the polyline
     *          - zoomFactor: should be used for creating the polyline
     */
    public function encode($points)
    {
        $absMaxDist = 0;
        $maxLoc = 0;
        $dists = [];

        if (count($points) > 2) {
            $stack[] = array(0, count($points) - 1);
            while (count($stack) > 0) {
                $current = array_pop($stack);
                $maxDist = 0;
                for ($i = $current[0] + 1; $i < $current[1]; $i++) {
                    $temp = $this->distance($points[$i], $points[$current[0]], $points[$current[1]]);
                    if ($temp > $maxDist) {
                        $maxDist = $temp;
                        $maxLoc = $i;
                        if ($maxDist > $absMaxDist) {
                            $absMaxDist = $maxDist;
                        }
                    }
                }
                if ($maxDist > $this->verySmall) {
                    $dists[$maxLoc] = $maxDist;
                    array_push($stack, array($current[0], $maxLoc));
                    array_push($stack, array($maxLoc, $current[1]));
                }
            }
        }

        $polyline = new \stdClass();
        $polyline->rawPoints = $this->createEncodings($points, $dists);
        $polyline->levels = $this->encodeLevels($points, $dists, $absMaxDist);
        $polyline->points = str_replace("\\", "\\\\", $polyline->rawPoints);
        $polyline->numLevels = $this->numLevels;
        $polyline->zoomFactor = $this->zoomFactor;

        return $polyline;
    }

    /**
     * Computes level
     *
     * @param int $dd
     *
     * @return int the computed level
     */
    private function computeLevel($dd)
    {
        $lev = 0;

        if ($dd > $this->verySmall) {
            while ($dd < $this->zoomLevelBreaks[$lev]) {
                $lev++;
            }
        }
        return $lev;
    }

    /**
     * Calculates the distance between point locations
     *
     * @param int $p0
     * @param int $p1
     * @param int $p2
     *
     * @return float
     */
    private function distance($p0, $p1, $p2)
    {
        $out = null;

        if ($p1[0] == $p2[0] && $p1[1] == $p2[1]) {
            $out = sqrt(pow($p2[0] - $p0[0], 2) + pow($p2[1] - $p0[1], 2));
        } else {
            $u = (($p0[0] - $p1[0]) * ($p2[0] - $p1[0]) + ($p0[1] - $p1[1]) * ($p2[1] - $p1[1])) / (pow(
                        $p2[0] - $p1[0],
                        2
                    ) + pow($p2[1] - $p1[1], 2));
            if ($u <= 0) {
                $out = sqrt(pow($p0[0] - $p1[0], 2) + pow($p0[1] - $p1[1], 2));
            }
            if ($u >= 1) {
                $out = sqrt(pow($p0[0] - $p2[0], 2) + pow($p0[1] - $p2[1], 2));
            }
            if (0 < $u && $u < 1) {
                $out = sqrt(
                    pow($p0[0] - $p1[0] - $u * ($p2[0] - $p1[0]), 2) + pow($p0[1] - $p1[1] - $u * ($p2[1] - $p1[1]), 2)
                );
            }
        }
        return $out;
    }

    /**
     * Encodes a signed number
     *
     * @param float $num
     *
     * @return string
     */
    private function encodeSignedNumber($num)
    {
        $sgn_num = $num << 1;
        if ($num < 0) {
            $sgn_num = ~($sgn_num);
        }
        return $this->encodeNumber($sgn_num);
    }

    /**
     * Encodes points
     *
     * @param array $points
     * @param array $dists
     *
     * @return string the encoded points
     */
    private function createEncodings($points, $dists)
    {
        $plat = 0;
        $plng = 0;
        $encoded_points = '';

        for ($i = 0; $i < count($points); $i++) {
            if (isset($dists[$i]) || $i == 0 || $i == count($points) - 1) {
                $point = $points[$i];
                $lat = $point[0];
                $lng = $point[1];
                $late5 = floor($lat * 1e5);
                $lnge5 = floor($lng * 1e5);
                $dlat = $late5 - $plat;
                $dlng = $lnge5 - $plng;
                $plat = $late5;
                $plng = $lnge5;
                $encoded_points .= $this->encodeSignedNumber($dlat) . $this->encodeSignedNumber($dlng);
            }
        }
        return $encoded_points;
    }

    /**
     * Encodes levels
     *
     * @param array $points
     * @param array $dists
     * @param int $absMaxDist
     *
     * @return string
     */
    private function encodeLevels($points, $dists, $absMaxDist)
    {
        $encoded_levels = '';

        if ($this->forceEndpoints) {
            $encoded_levels .= $this->encodeNumber($this->numLevels - 1);
        } else {
            $encoded_levels .= $this->encodeNumber($this->numLevels - $this->computeLevel($absMaxDist) - 1);
        }
        for ($i = 1; $i < count($points) - 1; $i++) {
            if (isset($dists[$i])) {
                $encoded_levels .= $this->encodeNumber($this->numLevels - $this->computeLevel($dists[$i]) - 1);
            }
        }
        if ($this->forceEndpoints) {
            $encoded_levels .= $this->encodeNumber($this->numLevels - 1);
        } else {
            $encoded_levels .= $this->encodeNumber($this->numLevels - $this->computeLevel($absMaxDist) - 1);
        }
        return $encoded_levels;
    }

    /**
     * Encondes a number
     *
     * @param int $num
     *
     * @return string
     */
    private function encodeNumber($num)
    {
        $encodeString = '';

        while ($num >= 0x20) {
            $nextValue = (0x20 | ($num & 0x1f)) + 63;
            $encodeString .= chr($nextValue);
            $num >>= 5;
        }
        $finalValue = $num + 63;
        $encodeString .= chr($finalValue);
        return $encodeString;
    }

    /**
     * Helper function to encode coordinates when there is no required to configure the encoder
     *
     * @param LatLng[] $coords
     *
     * @return string
     */
    public static function encodeCoordinates($coords)
    {
        static $encoder;

        if ($encoder == null) {
            $encoder = new self();
        }

        $points = [];
        foreach ($coords as $coord) {
            $points[] = explode(',', $coord);
        }

        return "enc:{$encoder->encode($points)}";
    }
} 