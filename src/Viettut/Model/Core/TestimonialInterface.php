<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 9:07 PM
 */

namespace Viettut\Model\Core;


use Viettut\Model\ModelInterface;

interface TestimonialInterface extends ModelInterface
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
    public function getName(): string;

    /**
     * @param string $name
     * @return self
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getProfession(): string;

    /**
     * @param string $profession
     * @return self
     */
    public function setProfession($profession);

    /**
     * @return string
     */
    public function getImage(): string;

    /**
     * @param string $image
     * @return self
     */
    public function setImage($image);

    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @param string $content
     * @return self
     */
    public function setContent($content);
}