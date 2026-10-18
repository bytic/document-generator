<?php

namespace ByTIC\DocumentGenerator\Letters;

/**
 * Class LettersManager
 * @package ByTIC\DocumentGenerator\Letters
 */
class LettersManager
{
    protected $managersClasses = null;

    /**
     * @return array
     */
    public function getManagerClasses()
    {
        if ($this->managersClasses === null) {
            $this->managersClasses = $this->locateManagerClasses();
        }

        return $this->managersClasses;
    }

    /**
     * @param string $class
     */
    public function addManagerClass($class)
    {
        $this->managersClasses[$class] = $class;
    }

    /**
     * @return array
     */
    protected function locateManagerClasses()
    {
        return [];
    }
}
