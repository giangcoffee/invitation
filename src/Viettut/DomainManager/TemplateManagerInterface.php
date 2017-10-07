<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 10:07 PM
 */

namespace Viettut\DomainManager;


use Viettut\Model\Core\ChapterInterface;
use Viettut\Model\Core\CourseInterface;
use Viettut\Model\Core\TutorialInterface;

interface TemplateManagerInterface extends ManagerInterface
{
    /**
     * @param string $hash
     * @return mixed
     */
    public function getTemplateByHash($hash);
}