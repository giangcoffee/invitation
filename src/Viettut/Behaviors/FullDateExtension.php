<?php
namespace Viettut\Behaviors;

class FullDateExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('long_date', array($this, 'longDate')),
        );
    }

    public function longDate($date, $locale = "vi_VN")
    {
        $fmt = new \IntlDateFormatter( $locale, \IntlDateFormatter::FULL, \IntlDateFormatter::FULL, 'Asia/Ho_Chi_Minh', \IntlDateFormatter::GREGORIAN, 'EEEE, dd LLLL, YYYY');
        return $fmt->format($date);
    }

    public function getName()
    {
        return 'date_extension';
    }
}