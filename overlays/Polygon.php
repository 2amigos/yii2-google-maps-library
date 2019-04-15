<?php

/*
 *
 * @copyright Copyright (c) 2013-2019 2amigos 
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 *
 */

namespace dosamigos\google\maps\overlays;

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\LatLngBounds;
use dosamigos\google\maps\OverlayTrait;
use yii\helpers\ArrayHelper;

/**
 * Polygon
 *
 * Object to render polygons on the map.
 *
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * 
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class Polygon extends PolygonOptions
{
    use OverlayTrait;

    /**
     * Sets the options based on a MarkerOptions object
     *
     * @param PolygonOptions $polylineOptions
     */
    public function setOptions(PolygonOptions $polylineOptions)
    {
        $options = array_filter($polylineOptions->options);
        $this->options = ArrayHelper::merge($this->options, $options);
    }

    /**
     * Returns the center coordinates of paths
     * @return \dosamigos\google\maps\LatLng|null
     */
    public function getCenterOfPaths()
    {
        $paths = ArrayHelper::getValue($this->options, 'paths');

        return is_array($paths) && !empty($paths)
            ? LatLngBounds::getBoundsOfCoordinates($paths)->getCenterCoordinates()
            : null;
    }

    /**
     * Returns the center of bounds
     * @return \dosamigos\google\maps\LatLng
     */
    public function getCenterOfBounds()
    {
        return LatLngBounds::getBoundsOfPolygons([$this])->getCenterCoordinates();
    }

    /**
     * Returns the js code to create a rectangle on a map
     * @return string
     */
    public function getJs()
    {
        $js = $this->getInfoWindowJs();

        $js[] = "var {$this->getName()} = new google.maps.Polygon({$this->getEncodedOptions()});";

        foreach ($this->events as $event) {
            /** @var \dosamigos\google\maps\Event $event */
            $js[] = $event->getJs($this->getName());
        }

        return implode("\n", $js);
    }

    /**
     * Returns true if coordinate is within polygon
     *
     * @param LatLng $coord
     * @param bool $isCheckVertex Check if the point sits exactly on one of the vertices? Default is false.
     *
     * @return boolean true if the coordinate is inside polygon
     */
    public function containsCoordinate(LatLng $coord, $isCheckVertex = false)
    {
        // Check if the point sits exactly on a vertex
        if ($isCheckVertex == true && $this->isOnVertexOfPolygon($coord) == true) {
            return true; // vertex
        }

        // Check if the point is inside the polygon or on the boundary
        $intersections = 0;
        $paths = ArrayHelper::getValue($this->options, 'paths');
        $vertexCount = count($paths);

        for ($i = 1; $i < $vertexCount; $i++) {
            $vertex1 = $paths[$i - 1];
            $vertex2 = $paths[$i];

            // Check if point is on a latitude polygon boundary
            if ($vertex1->lat == $vertex2->lat &&
                $vertex1->lat == $coord->lat &&
                $coord->lng > min($vertex1->lng, $vertex2->lng) &&
                $coord->lng < max($vertex1->lng, $vertex2->lng)
            ) {
                return true; // boundary
            }

            // Check if point is on a longitude polygon boundary
            if ($coord->lat > min($vertex1->lat, $vertex2->lat) &&
                $coord->lat <= max($vertex1->lat, $vertex2->lat) &&
                $coord->lng <= max($vertex1->lng, $vertex2->lng) &&
                $vertex1->lat != $vertex2->lat
            ) {
                $xinters = $coord->lat - $vertex1->lat;
                $xinters = $xinters * ($vertex2->lng - $vertex1->lng);
                $xinters = $xinters / ($vertex2->lat - $vertex1->lat);
                $xinters = $xinters + $vertex1->lng;

                if ($xinters == $coord->lng) {
                    return true; // boundary
                }
                if ($vertex1->lng == $vertex2->lng || $coord->lng <= $xinters) {
                    $intersections++;
                }
            }
        }

        // If the number of edges we passed through is odd, then it's in the polygon.
        if ($intersections % 2 != 0) {
            return true; // inside
        }
        return false; // outside
    }

    /**
     * Returns true if coordinate is vertex of polygon.
     *
     * @param LatLng $coord
     *
     * @return bool whether point is vertex of polygon
     */
    public function isCoordinateOnVertex(LatLng $coord)
    {
        $paths = ArrayHelper::getValue($this->options, 'paths');
        foreach ($paths as $vertex) {
            if ($vertex->lat == $coord->lat && $vertex->lng == $coord->lng) {
                return true;
            }
        }
        return false;
    }
}
