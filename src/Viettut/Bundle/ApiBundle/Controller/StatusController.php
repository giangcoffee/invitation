<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 10:24 PM
 */

namespace Viettut\Bundle\ApiBundle\Controller;


use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Viettut\Entity\Core\Status;
use Viettut\Exception\InvalidArgumentException;
use Viettut\Handler\HandlerInterface;
use Viettut\Model\Core\CardInterface;
use Viettut\Model\Core\ChapterInterface;
use Viettut\Model\Core\CommentInterface;
use Viettut\Model\Core\CourseInterface;
use Viettut\Model\Core\StatusInterface;
use Viettut\Repository\Core\StatusRepositoryInterface;

/**
 * @RouteResource("Status")
 */
class StatusController extends RestControllerAbstract implements ClassResourceInterface
{

    /**
     * Get all comment
     *
     * @Rest\View(
     *      serializerGroups={"chapter.summary", "user.summary", "course.summary", "tutorial.summary"}
     * )
     *
     * @ApiDoc(
     *  resource = true,
     *  statusCodes = {
     *      200 = "Returned when successful"
     *  }
     * )
     *
     * @return CommentInterface[]
     */
    public function cgetAction()
    {
        return $this->all();
    }

    /**
     * Get a single comment for the given id
     *
     * @Rest\View(
     *      serializerGroups={"chapter.summary", "user.summary", "course.summary", "tutorial.summary"}
     * )
     * @ApiDoc(
     *  resource = true,
     *  statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the resource is not found"
     *  }
     * )
     *
     * @param int $id the resource id
     *
     * @return CommentInterface
     * @throws NotFoundHttpException when the resource does not exist
     */
    public function getAction($id)
    {
        return $this->one($id);
    }


    /**
     * Create a comment from the submitted data
     *
     * @ApiDoc(
     *  resource = true,
     *  statusCodes = {
     *      200 = "Returned when successful",
     *      400 = "Returned when the submitted data has errors"
     *  }
     * )
     *
     * @param Request $request the request object
     */
    public function postAction(Request $request)
    {
        $cardId = $request->request->get('card', 0);
        $status = $request->request->get('status', 0);

        if ($cardId == 0 || $status == 0) {
            throw new InvalidArgumentException('Either "cardId" or "status" is invalid');
        }

        $card = $this->get('viettut.domain_manager.card')->find($cardId);
        if (!$card instanceof CardInterface) {
            throw new InvalidArgumentException('Card "%s" is not found or you do not have permission', $cardId);
        }

        $uniqueUser = null;
        if (array_key_exists('user_unique_id', $_COOKIE)) {
            $uniqueUser = $_COOKIE['user_unique_id'];
        }

        if ($uniqueUser == null) {
            return new Response("", Response::HTTP_NO_CONTENT);
        }

        /** @var StatusRepositoryInterface $statusRepository */
        $statusRepository = $this->get('viettut.repository.status');
        $statusEntity = $statusRepository->checkUniqueUserForCard($card, $uniqueUser);
        if ($statusEntity instanceof StatusInterface) {
            $statusEntity->setStatus($status);
        } else {
            $statusEntity = new Status();
            $statusEntity->setStatus($status)->setCard($card)->setUniqueUser($uniqueUser);
        }

        $this->get('viettut.domain_manager.status')->save($statusEntity);
        return new Response("", Response::HTTP_NO_CONTENT);
    }

    /**
     * @return string
     */
    protected function getResourceName()
    {
        return 'status';
    }

    /**
     * The 'get' route name to redirect to after resource creation
     *
     * @return string
     */
    protected function getGETRouteName()
    {
        return 'api_1_get_status';
    }

    /**
     * @return HandlerInterface
     */
    protected function getHandler()
    {
        return $this->container->get('viettut_api.handler.status');
    }
}