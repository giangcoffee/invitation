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
    protected $createdAt;
    protected $deletedAt;
}