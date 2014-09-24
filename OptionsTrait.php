<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps;


trait OptionsTrait
{
    /**
     * @return string the js constructor of the object
     */
    public function getJs()
    {
        $name = $this->getName(false) ? "var {$this->getName()} = " : "";
        $options = $this->getEncodedOptions();
        return "{$name}{$options}";
    }
} 