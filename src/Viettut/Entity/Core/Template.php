<?php


namespace Viettut\Entity\Core;

use Viettut\Model\Core\Template as TemplateModel;
class Template extends TemplateModel
{
    protected $id;
    protected $name;
    protected $hash;
    protected $path;
    protected $data;
    protected $gallery;
    protected $thumbnail;
    protected $weddingDate;
    protected $columns;
    protected $createdAt;
    protected $deletedAt;
    protected $latitude;
    protected $longitude;
}