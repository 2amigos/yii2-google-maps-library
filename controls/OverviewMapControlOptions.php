<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace extensions\google\controls\maps;


use dosamigos\google\maps\ObjectAbstract;
use dosamigos\google\maps\OptionsTrait;
use yii\helpers\ArrayHelper;

/**
 * OverviewMapControlOptions
 *
 * Options for the rendering of the Overview Map control.
 *
 * For further information please visit its
 * [documentation](https://developers.google.com/maps/documentation/javascript/reference#OverviewMapControlOptions) at
 * Google.
 *
 * @property boolean opened Whether the control should display in opened mode or collapsed (minimized) mode. By default,
 * the control is closed.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package extensions\google\controls\maps
 */
class OverviewMapControlOptions extends ObjectAbstract
{
    use OptionsTrait;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->options = ArrayHelper::merge(['opened' => null], $this->options);
    }

} 