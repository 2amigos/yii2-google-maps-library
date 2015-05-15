<?php
/**
 * @link https://github.com/2amigos/yii2-google-maps-library
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
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
