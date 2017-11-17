<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 9/27/15
 * Time: 11:31 AM
 */
namespace Viettut\Utilities;
use DOMDocument;
use DOMXPath;

trait StringFactory {
    /**
     * generate dash-separated string which is url-friendly
     *
     * @param $str
     * @return string
     */
    protected  function getUrlFriendlyString($str)
    {
        $str = $this->convertViToEn($str);
        return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $str), '-'));
    }

    /**
     * extract the first paragraph from a sequence of string
     *
     * @param $string
     * @return string
     */
    protected function getFirstParagraph($string)
    {
        $dom = new DOMDocument();
        $dom->loadHTML($string);
        $xp = new DOMXPath($dom);

        $res = $xp->query('//p');

        return $res[0]->nodeValue;
    }

    protected function convertViToEn($str)
    {
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/', 'A', $str);
        $str = preg_replace('/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/', 'E', $str);
        $str = preg_replace('/(Ì|Í|Ị|Ỉ|Ĩ)/', 'I', $str);
        $str = preg_replace('/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/', 'O', $str);
        $str = preg_replace('/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/', 'U', $str);
        $str = preg_replace('/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/', 'Y', $str);
        $str = preg_replace('/(Đ)/', 'D', $str);

        return $str;
    }

    protected function generateUsername($name, $rand_no = 200)
    {
        while (true) {
            $username_parts = array_filter(explode(" ", strtolower($name))); //explode and lowercase name
            $username_parts = array_slice($username_parts, 0, 2); //return only first two arry part

            $part1 = (!empty($username_parts[0]))?substr($username_parts[0], 0,8):""; //cut first name to 8 letters
            $part2 = (!empty($username_parts[1]))?substr($username_parts[1], 0,5):""; //cut second name to 5 letters
            $part3 = ($rand_no)?rand(0, $rand_no):"";

            $username = $part1. str_shuffle($part2). $part3; //str_shuffle to randomly shuffle all characters

            $username_exist_in_db = username_exist_in_database($username); //check username in database
            if(!$username_exist_in_db){
                return $username;
            }
        }
    }
}