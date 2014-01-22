<?php

namespace Mastercoding\Conquest\Bot\Helper;

class Path
{

    /**
     * Find the shortest path from starting region to closest destination region
     * using
     * breadth-first search (BFS).
     *
     * @param \Mastercoding\Conquest\Object\map $map
     * @param \Mastercoding\Conquest\Object\Region $startingRegion
     * @param \SplObjectStorage $destinationRegions
     * @param bool $onlyYours
     */
    public static function closestRegion(\Mastercoding\Conquest\Object\map $map, \Mastercoding\Conquest\Object\Region $startingRegion, \SplObjectStorage $destinationRegions, $onlyYours = false)
    {

        // missuse priority queu
        $closestQueue = new \SplPriorityQueue;
        foreach ($destinationRegions as $destinationRegion) {

            $path = self::shortestPath($map, $startingRegion, $destinationRegion, $onlyYours);
            if (null !== $path) {
                $closestQueue->insert($destinationRegion, -1 * count($path));
            }

        }

        // get top
        if (count($closestQueue) > 0) {
            $topDestination = $closestQueue->top();
            return $topDestination;
        }

        // nothing
        return null;

    }

    /**
     * Find the shortest path from starting region to destination region using
     * breadth-first search (BFS). Don't know if it's according to spec, but it
     * works.
     *
     * @param \Mastercoding\Conquest\Object\map $map
     * @param \Mastercoding\Conquest\Object\Region $startingRegion
     * @param \Mastercoding\Conquest\Object\Region $destinationRegion
     * @param bool $onlyYours
     */
    public static function shortestPath(\Mastercoding\Conquest\Object\map $map, \Mastercoding\Conquest\Object\Region $startingRegion, \Mastercoding\Conquest\Object\Region $destinationRegion, $onlyYours = false)
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

                // yours
                if ($onlyYours && $neighbor->getOwner() != $map->getYou()) {
                    continue;
                }

                // mark visited and track path
                if (!isset($visited[$neighbor->getId()])) {

                    $parents[$neighbor->getId()] = $queue[$i];
                    $visited[$neighbor->getId()] = true;

                    // add neighbors to queue
                    if ($neighbor->hasNeighbors()) {
                        $queue[] = $neighbor;
                    }

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
                        $object = isset($parents[$object->getId()]) ? $parents[$object->getId()] : null;

                    }

                    return $path;

                }

            }

        }

        // no path
        return null;

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
