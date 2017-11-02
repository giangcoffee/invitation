<?php


namespace Viettut\Entity\Core;

use Viettut\Model\Core\Testimonial as TestimonialModel;
class Testimonial extends TestimonialModel
{
    protected $id;
    protected $name;
    protected $profession;
    protected $image;
    protected $content;
    protected $createdAt;
}