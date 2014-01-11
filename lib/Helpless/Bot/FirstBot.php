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
     * Capture north america strategy
     *
     * @var \Helpless\Bot\Strategy\CaptureContinent
     */
    private $captureNorthAmerica;

    /**
     * Capture europe
     *
     * @var \Helpless\Bot\Strategy\CaptureContinent
     */
    private $captureEurope;

    /**
     * Capture africa
     *
     * @var \Helpless\Bot\Strategy\CaptureContinent
     */
    private $captureAfrica;

    /**
     * Capture asia
     *
     * @var \Helpless\Bot\Strategy\CaptureContinent
     */
    private $captureAsia;

    /**
     * Go from south to north
     *
     * @var \Helpless\Bot\Strategy\CrossContinent
     */
    private $crossSouthToNorthAmerica;

    /**
     * Go from north america to europe
     *
     * @var \Helpless\Bot\Strategy\CrossContinent
     */
    private $crossNorthAmericaToEurope;

    /**
     * Go from south america to africa
     *
     * @var \Helpless\Bot\Strategy\CrossContinent
     */
    private $crossSouthAmericaToAfrica;

    /**
     * Go from aussie to asia
     *
     * @var \Helpless\Bot\Strategy\CrossContinent
     */
    private $crossAustraliaToAsia;

    /**
     * Setup listeners
     */
    public function __construct($map, $eventDispatcher)
    {
        parent::__construct($map, $eventDispatcher);

        // setup listeners
        $eventDispatcher->addListener(\Mastercoding\Conquest\Event::SETUP_MAP_COMPLETE, array($this, 'setupMapComplete'));
        $eventDispatcher->addListener(\Mastercoding\Conquest\Event::AFTER_UPDATE_MAP, array($this, 'mapUpdate'));

    }

    /**
     * After map has been updated
     */
    public function mapUpdate()
    {

    }

    /**
     * The map has been set-up
     */
    public function setupMapComplete()
    {

        // conquer australia
        $southAmerica = \Mastercoding\Conquest\Bot\Helper\Risk::getNamedContinent($this->getMap(), 'South America');
        $this->captureSouthAmerica = new \Helpless\Bot\Strategy\CaptureContinent();
        $this->captureSouthAmerica->setContinent($southAmerica);

        // conquer south america
        $australia = \Mastercoding\Conquest\Bot\Helper\Risk::getNamedContinent($this->getMap(), 'Australia');
        $this->captureAustralia = new \Helpless\Bot\Strategy\CaptureContinent();
        $this->captureAustralia->setContinent($australia);

        // conquer north america
        $northAmerica = \Mastercoding\Conquest\Bot\Helper\Risk::getNamedContinent($this->getMap(), 'North America');
        $this->captureNorthAmerica = new \Helpless\Bot\Strategy\CaptureContinent();
        $this->captureNorthAmerica->setContinent($northAmerica);

        // conquer europe
        $europe = \Mastercoding\Conquest\Bot\Helper\Risk::getNamedContinent($this->getMap(), 'Europe');
        $this->captureEurope = new \Helpless\Bot\Strategy\CaptureContinent();
        $this->captureEurope->setContinent($europe);

        // conquer africa
        $africa = \Mastercoding\Conquest\Bot\Helper\Risk::getNamedContinent($this->getMap(), 'Africa');
        $this->captureAfrica = new \Helpless\Bot\Strategy\CaptureContinent();
        $this->captureAfrica->setContinent($africa);

        // conquer asia
        $asia = \Mastercoding\Conquest\Bot\Helper\Risk::getNamedContinent($this->getMap(), 'Asia');
        $this->captureAsia = new \Helpless\Bot\Strategy\CaptureContinent();
        $this->captureAsia->setContinent($asia);

        // cross from south to north
        $this->crossSouthToNorthAmerica = new \Helpless\Bot\Strategy\CrossContinent;
        $this->crossSouthToNorthAmerica->setContinents($southAmerica, $northAmerica);

        // cross from north to europe
        $this->crossNorthAmericaToEurope = new \Helpless\Bot\Strategy\CrossContinent;
        $this->crossNorthAmericaToEurope->setContinents($northAmerica, $europe);

        // cross from north to europe
        $this->crossSouthAmericaToAfrica = new \Helpless\Bot\Strategy\CrossContinent;
        $this->crossSouthAmericaToAfrica->setContinents($southAmerica, $africa);

        // cross from north to europe
        $this->crossAustraliaToAsia = new \Helpless\Bot\Strategy\CrossContinent;
        $this->crossAustraliaToAsia->setContinents($australia, $asia);

        // set priorities, capture smallest continents, starting with australia
        // (aww)
        $this->captureAustralia->setPriority(10);
        $this->captureSouthAmerica->setPriority(9);

        // cross and capture
        $this->captureNorthAmerica->setPriority(8);
        $this->crossSouthToNorthAmerica->setPriority(7);

        // then to europe
        $this->captureEurope->setPriority(6);
        $this->crossNorthAmericaToEurope->setPriority(5);

        // then to africa
        $this->captureAfrica->setPriority(4);
        $this->crossSouthAmericaToAfrica->setPriority(3);

        // then to asia
        $this->captureAsia->setPriority(2);
        $this->crossAustraliaToAsia->setPriority(1);

        // register
        $this->addStrategy($this->captureAustralia);
        $this->addStrategy($this->captureSouthAmerica);
        $this->addStrategy($this->captureNorthAmerica);
        $this->addStrategy($this->captureEurope);
        $this->addStrategy($this->captureAfrica);
        $this->addStrategy($this->captureAsia);

        $this->addStrategy($this->crossSouthToNorthAmerica);
        $this->addStrategy($this->crossSouthAmericaToAfrica);
        $this->addStrategy($this->crossAustraliaToAsia);

        // pick armies random, we should never loose armies due to strategies not
        // needing them
        $randomArmies = new \Mastercoding\Conquest\Bot\Strategy\ArmyPlacement\Random;
        $this->addArmyPlacementStrategy($randomArmies);

        // pick regions, spread
        $spread = new \Mastercoding\Conquest\Bot\Strategy\RegionPicker\Spread();
        $this->addRegionPickerStrategy($spread);

    }

}
