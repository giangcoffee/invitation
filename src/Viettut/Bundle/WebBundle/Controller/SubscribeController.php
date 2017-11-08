<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 10:24 PM
 */

namespace Viettut\Bundle\WebBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Viettut\Exception\InvalidArgumentException;
use Viettut\Entity\Core\Subscriber;
use Viettut\Model\Core\SubscriberInterface;

class SubscribeController extends Controller
{
    /**
     * @Route("/subscribe")
     *
     * @param Request $request
     * @return Response
     */
    public function subscribeAction(Request $request)
    {
        $params = $request->request->all();
        if (!array_key_exists('email', $params)) {
            throw new InvalidArgumentException('email should not be missing');
        }

        $subscriber = $this->get('viettut.repository.subscriber')->getByEmail($params['email']);

        if (!$subscriber instanceof SubscriberInterface) {
            $subscriber = new Subscriber();
            $subscriber->setEmail($params['email']);
            $this->getDoctrine()->getEntityManager()->persist($subscriber);
            $this->getDoctrine()->getEntityManager()->flush();
        }

        return new Response("", Response::HTTP_NO_CONTENT);
    }
}