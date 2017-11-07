<?php


namespace Viettut\Services;


use Viettut\Bundle\UserBundle\DomainManager\LecturerManagerInterface;
use Viettut\Model\User\UserEntityInterface;

class UsernameService implements UsernameServiceInterface
{
    /** @var LecturerManagerInterface */
    protected $userManager;

    /**
     * UsernameService constructor.
     * @param LecturerManagerInterface $userManager
     */
    public function __construct(LecturerManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param $name
     * @param int $rand_no
     * @return string
     */
    public function generateUsername($name, $rand_no = 200)
    {
        while (true) {
            $usernameParts = array_filter(explode(" ", strtolower($name))); //explode and lowercase name
            $usernameParts = array_slice($usernameParts, 0, 2); //return only first two arry part

            $part1 = (!empty($usernameParts[0]))?substr($usernameParts[0], 0,8):""; //cut first name to 8 letters
            $part2 = (!empty($usernameParts[1]))?substr($usernameParts[1], 0,5):""; //cut second name to 5 letters
            $part3 = ($rand_no)?rand(0, $rand_no):"";

            $username = $part1. str_shuffle($part2). $part3; //str_shuffle to randomly shuffle all characters
            $user = $this->userManager->findUserByUsernameOrEmail($username);

            if(!$user instanceof UserEntityInterface){
                return $username;
            }
        }
    }
}