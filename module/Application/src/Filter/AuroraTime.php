<?php
namespace Application\Filter;

use Laminas\Filter\AbstractFilter;
use \DateTime;
use \DateTimeZone;

/**
 *
 * @author acesn
 *        
 */
class AuroraTime extends AbstractFilter
{
    const AURORA_FORMAT = 'j-m-Y g:i:s';
    const AURORA_TIMEZONE = 'America/Chicago';
    
    public $now;
    public $format;
    public $timezone;
    
    public function __construct($now = true, $format = null, $timezone = null)
    {
        $this->now = $now;
        $this->format = $format;
        $this->timezone = $timezone;
    }
    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\Filter\FilterInterface::filter()
     *
     *@var $value
     */
    public function filter($value)
    {
        $now = new DateTime();
        $now->setTimezone(new \DateTimeZone(AURORA_TIMEZONE));
        $now->format(AURORA_FORMAT);
        return $now;
    }
}

