<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps;

use Exception;
use Yii;
use yii\base\BaseObject;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client as HttpClient;

/**
 * ClientAbstract
 *
 * Base class for those objects that make requests to the Google Web Services API
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
abstract class ClientAbstract extends BaseObject
{
    /**
     * @var string response format. Can be json or xml.
     */
    public $format = 'json';
    /**
     * @var array the request parameters
     */
    public $params = [];
    /**
     * @var \Guzzle\Http\Client a client to make requests to the Google API
     */
    private $_guzzle;

    /**
     * Returns the api url
     * @return string
     */
    abstract public function getUrl();

    /**
     * @inheritdoc
     */
    public function init()
    {
        /** @var MapAsset|null $mapBundle */
        $mapBundle = @Yii::$app->getAssetManager()->getBundle(MapAsset::className());
        if ($mapBundle) {
            $this->params = array_merge($this->params, $mapBundle->options);
        }

        /** BACKWARD COMPATIBILITY */
        if (!isset($this->params['key']) || !$this->params['key']) {
            $this->params['key'] = @Yii::$app->params['googleMapsApiKey'] ? : null;
        }

        if (!$this->params['key']) {
            throw new Exception("Invalid configuration - missing Google API key! Configure MapAsset bundle in assetManager");
        }
    }

    /**
     * Makes the request to the Google API
     *
     * @param array $options for the guzzle request
     *
     * @return mixed|null
     */
    protected function request($options = [])
    {
        try {
            $params = array_filter($this->params);
            $response = $this->getClient()
                ->get($this->getUrl(), ['query' => $params], $options);

            return $this->format == 'json'
                ? json_decode($response->getBody())
                : simplexml_load_string($response->getBody());

        } catch (RequestException $e) {
            return null;
        }
    }

    /**
     * Returns the guzzle client
     * @return \Guzzle\Http\Client|HttpClient
     */
    protected function getClient()
    {
        if ($this->_guzzle == null) {
            $this->_guzzle = new HttpClient();
        }
        return $this->_guzzle;
    }
}
