<?php
namespace Viettut\Behaviors;

class FullTimeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('long_time', array($this, 'longTime')),
        );
    }

    public function longTime($date, $locale = "vi_VN")
    {
        $fmt = new \IntlDateFormatter( $locale, \IntlDateFormatter::FULL, \IntlDateFormatter::FULL, 'Asia/Ho_Chi_Minh', \IntlDateFormatter::GREGORIAN, 'EEEE, dd LLLL, YYYY hh:mm');
        return $fmt->format($date);
    }

    public function getName()
    {
        return 'date_extension';
    }
}