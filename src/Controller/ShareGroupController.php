<?php

namespace App\Controller;

use App\Entity\ShareGroup;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller
 * @Route("/sharegroup")
 */
class ShareGroupController extends BaseController
{
    /**
     * @Route("/", name="sharegroup_index", methods="GET")
     */
    public function index(Request $request): Response
    {
        $sharegroups = $this->getDoctrine()->getRepository(ShareGroup::class)
            ->createQueryBuilder('s')
            ->getQuery()
            ->getArrayResult();

        if ($request->isXmlHttpRequest()) {
            return $this->json($sharegroups);
        }
    }

    /**
     * @Route("/new", name="sharegroup_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $sharegroup = new ShareGroup();

        $slug = $request->get('slug');
        $sharegroup->setSlug($slug);

        $em = $this->getDoctrine()->getManager();
        $em->persist($sharegroup);
        $em->flush();


    }
}
