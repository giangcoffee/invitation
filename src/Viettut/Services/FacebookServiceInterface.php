<?php


namespace Viettut\Services;


use Viettut\Model\Core\CardInterface;

interface FacebookServiceInterface
{
    /**
     * @param CardInterface $card
     * @return array
     */
    public function getCommentsForCard(CardInterface $card);

    /**
     * @param CardInterface $card
     * @return null|string
     */
    public function getGraphObjectIdForCard(CardInterface $card);
}