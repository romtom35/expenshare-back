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
     * @Route("/", name="sharegroup_list", methods="GET")
     */
    public function index(Request $request): Response
    {
        $persons = $this->getDoctrine()->getRepository(ShareGroup::class)
            ->createQueryBuilder('s')
            ->getQuery()
            ->getArrayResult();

        if ($request->isXmlHttpRequest()) {
            return $this->json($persons);
        }
    }
}
