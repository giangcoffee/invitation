<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 9:07 PM
 */

namespace Viettut\Model\Core;


use Viettut\Model\ModelInterface;

interface FaqInterface extends ModelInterface
{
    /**
     * @param int $id
     * @return self
     */
    public function setId($id);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getQuestion(): string;

    /**
     * @param string $question
     * @return self
     */
    public function setQuestion($question);

    /**
     * @return string
     */
    public function getAnswer(): string;

    /**
     * @param string $answer
     * @return self
     */
    public function setAnswer($answer);
}