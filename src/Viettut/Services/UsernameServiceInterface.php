<?php


namespace Viettut\Services;


interface UsernameServiceInterface
{
    /**
     * @param $name
     * @param int $rand_no
     * @return mixed
     */
    public function generateUsername($name, $rand_no = 200);
}