<?php
namespace Viettut\Behaviors;

class DayExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('full_day', array($this, 'fullDay')),
        );
    }

    public function fullDay($date, $locale = "vi_VN")
    {
        $fmt = new \IntlDateFormatter( $locale, \IntlDateFormatter::FULL, \IntlDateFormatter::FULL, 'Asia/Ho_Chi_Minh', \IntlDateFormatter::GREGORIAN, 'EEEE');
        return $fmt->format($date);
    }

    public function getName()
    {
        return 'date_extension';
    }
}