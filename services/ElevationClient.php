<?php

/*
 *
 * @copyright Copyright (c) 2013-2019 2amigos 
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 *
 */

namespace dosamigos\google\maps\services;

use dosamigos\google\maps\ClientAbstract;
use dosamigos\google\maps\Encoder;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * ElevationClient
 *
 * Utility class to call Google's Elevation API. For further information, please visit
 * https://developers.google.com/maps/documentation/elevation/
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 * 
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class ElevationClient extends ClientAbstract
{
    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        $this->params = ArrayHelper::merge(
            [
                'locations' => null,
                'path' => null,
                'samples' => null
            ],
            $this->params
        );

        parent::__construct($config);
    }

    /**
     * Returns the api url
     * @return string
     */
    public function getUrl()
    {
        return 'https://maps.googleapis.com/maps/api/elevation/' . $this->format;
    }

    /**
     * Makes elevation request by locations
     *
     * @param \dosamigos\google\maps\LatLng[] $coords
     * @param bool $encode
     *
     * @return mixed|null
     */
    public function byLocations($coords, $encode = true)
    {
        $this->params['locations'] = $encode
            ? Encoder::encodeCoordinates($coords)
            : implode('|', $coords);

        return parent::request();
    }

    /**
     * Makes elevation request by paths
     *
     * @param \dosamigos\google\maps\LatLng[] $coords defines a path on the earth for which to return elevation data.
     * @param int $samples specifies the number of sample points along a path for which to return the elevation data.
     * @param bool $encode
     *
     * @return mixed|null
     */
    public function byPath($coords, $samples, $encode = true)
    {
        $this->params['path'] = $encode
            ? Encoder::encodeCoordinates($coords)
            : implode('|', $coords);

        $this->params['samples'] = $samples;

        return parent::request();
    }
}
