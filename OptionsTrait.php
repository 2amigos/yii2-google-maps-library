<?php

/*
 *
 * @copyright Copyright (c) 2013-2019 2amigos 
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 *
 */

namespace dosamigos\google\maps;

/**
 * OptionsTrait
 *
 * Contains common functions for option classes.
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 *
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
trait OptionsTrait
{
    /**
     * @return string the js constructor of the object
     */
    public function getJs()
    {
        $name = $this->getName(false) ? "var {$this->getName()} = " : "";
        $end = $this->getName(false) ? ";" : "";
        $options = $this->getEncodedOptions();
        return "{$name}{$options}{$end}";
    }
}
