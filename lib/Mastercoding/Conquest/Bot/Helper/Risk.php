<?php

namespace Mastercoding\Conquest\Bot\Helper;

class Risk
{

    /**
     * Get named continent a la risk
     *
     * @param \Mastercoding\Conquest\Object\Map $map
     * @param string $name
     * @return \Mastercoding\Conquest\Object\Continent
     */
    public static function getNamedContinent(\Mastercoding\Conquest\Object\Map $map, $name)
    {

        // static continent mapping
        $continentMapping = array();
        $continentMapping['North America'] = array('regions' => 10, 'id' => 1);
        $continentMapping['South America'] = array('regions' => 4, 'id' => 2);
        $continentMapping['Europe'] = array('regions' => 7, 'id' => 3);
        $continentMapping['Africa'] = array('regions' => 6, 'id' => 4);
        $continentMapping['Asia'] = array('regions' => 12, 'id' => 5);
        $continentMapping['Australia'] = array('regions' => 4, 'id' => 6);

        // set
        if (!isset($continentMapping[$name])) {
            throw new Exception('Continent with name: ' . $name . ' is not defined. Defined continents are: ' . implode(',', array_keys($continentMapping)));
        }

        // get mapping
        $continentMap = $continentMapping[$name];
        return $map->getContinentById($continentMap['id']);

    }

}
