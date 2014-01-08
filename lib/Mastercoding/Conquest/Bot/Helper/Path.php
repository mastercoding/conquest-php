<?php

namespace Mastercoding\Conquest\Bot\Helper;

class Path
{

    /**
     * Find the shortest path from starting region to destination region using
     * breadth-first search (BFS). Don't know if it's according to spec, but it
     * works.
     *
     * @param \Mastercoding\Conquest\Object\map $map
     * @param \Mastercoding\Conquest\Object\Region $startingRegion
     * @param \Mastercoding\Conquest\Object\Region $destinationRegion
     */
    public static function shortestPath(\Mastercoding\Conquest\Object\map $map, \Mastercoding\Conquest\Object\Region $startingRegion, \Mastercoding\Conquest\Object\Region $destinationRegion)
    {

        // same?
        if ($startingRegion->getId() == $destinationRegion->getId()) {
            throw new \Exception('Starting region is destination region');
        }

        // level
        $level = 0;

        // loop queue
        $queue = array($startingRegion);
        $visited = array($startingRegion->getId() => true);

        // list keeping
        $parents = array();

        // loop
        for ($i = 0; $i < count($queue); $i++) {

            foreach ($queue[$i]->getNeighbors() as $neighbor) {

                // mark visited and track path
                if (!isset($visited[$neighbor->getId()])) {

                    $parents[$neighbor->getId()] = $queue[$i];
                    $visited[$neighbor->getId()] = true;

                }

                // this one the one we want?
                if ($neighbor->getId() == $destinationRegion->getId()) {

                    // the end
                    $object = $neighbor;
                    $path = array();

                    // track back path
                    $j = 0;
                    while (is_object($object) && ++$j) {

                        $path[] = $object;
                        $object = $parents[$object->getId()];

                    }

                    return $path;

                } else {

                    // add neighbors to queue
                    if ($neighbor->hasNeighbors()) {
                        $queue[] = $neighbor;
                    }

                }

            }

        }

    }

    /**
     * Check if the path is yours (can you walk it)
     *
     * @param \Mastercoding\Conquest\Object\map $map
     * @param Array $path
     * @return bool
     */
    public function pathYours(\Mastercoding\Conquest\Object\map $map, Array $path)
    {
        foreach ($path as $region) {
            if ($region->getOwner() != $map->getYou())
                return false;
        }

        return true;

    }

}
