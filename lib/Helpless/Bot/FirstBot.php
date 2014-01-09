<?php

namespace Helpless\Bot;
class FirstBot extends \Mastercoding\Conquest\Bot\StrategicBot
{

    /**
     * Setup listeners
     */
    public function __construct($map, $eventDispatcher)
    {
        parent::__construct($map, $eventDispatcher);

        // setup listeners
        $eventDispatcher->addListener(\Mastercoding\Conquest\Event::SETUP_MAP_COMPLETE, array($this, 'mapSetupComplete'));
        $eventDispatcher->addListener(\Mastercoding\Conquest\Event::AFTER_UPDATE_MAP, array($this, 'mapUpdate'));

    }
    
    private function reorderContinentCapture()
    {
        
        
        
    }

    /**
     * After map has been updated
     */
    public function mapUpdate()
    {
        
        $this->reorderContinentCapture();        

    }

    /**
     * The map has been set-up
     */
    public function mapSetupComplete()
    {

        // conquer australia, conquer south america
        $australia = \Mastercoding\Conquest\Bot\Helper\Risk::getNamedContinent($this->getMap(), 'Australia');
        $captureAustralia = new \Helpless\Bot\Strategy\CaptureContinent();
        $captureAustralia->setContinent($australia);

        // conquer australia, conquer south america
        $southAmerica = \Mastercoding\Conquest\Bot\Helper\Risk::getNamedContinent($this->getMap(), 'South America');
        $captureSouthAmerica = new \Helpless\Bot\Strategy\CaptureContinent();
        $captureSouthAmerica->setContinent($southAmerica);

        // register
        $this->addStrategy($captureAustralia, 2);
        $this->addStrategy($captureSouthAmerica, 1);

        // pick regions, spread
        $this->addRegionPickerStrategy(new \Mastercoding\Conquest\Bot\Strategy\RegionPicker\Spread());

    }
    

}
