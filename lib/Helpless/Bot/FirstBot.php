<?php

namespace Helpless\Bot;
class FirstBot extends \Mastercoding\Conquest\Bot\StrategicBot
{

    /**
     * Capture australia strategy
     *
     * @var \Helpless\Bot\Strategy\CaptureContinent
     */
    private $captureAustralia;

    /**
     * Capture south america strategy
     *
     * @var \Helpless\Bot\Strategy\CaptureContinent
     */
    private $captureSouthAmerica;

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

        // going for continent with the most regions captured first
        $australia = \Mastercoding\Conquest\Bot\Helper\Risk::getNamedContinent($this->getMap(), 'Australia');

    }

    /**
     * The map has been set-up
     */
    public function mapSetupComplete()
    {

        // conquer australia, conquer south america
        $australia = \Mastercoding\Conquest\Bot\Helper\Risk::getNamedContinent($this->getMap(), 'Australia');
        $this->captureAustralia = new \Helpless\Bot\Strategy\CaptureContinent();
        $this->captureAustralia->setPriority(2);
        $this->captureAustralia->setContinent($australia);

        // conquer australia, conquer south america
        $southAmerica = \Mastercoding\Conquest\Bot\Helper\Risk::getNamedContinent($this->getMap(), 'South America');
        $this->captureSouthAmerica = new \Helpless\Bot\Strategy\CaptureContinent();
        $this->captureSouthAmerica->setPriority(1);
        $this->captureSouthAmerica->setContinent($southAmerica);

        // register
        $this->addStrategy($this->captureAustralia);
        $this->addStrategy($this->captureSouthAmerica);

        // pick regions, spread
        #$spread = new \Mastercoding\Conquest\Bot\Strategy\RegionPicker\Spread();
        #$this->addRegionPickerStrategy($spread);

    }

}
