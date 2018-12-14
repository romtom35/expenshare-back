<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller
 * @Route("/category")
 */
class CategoryController extends BaseController
{
    /**
     * @Route("/", name="category_list", methods="GET")
     */
    public function index(Request $request): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)
            ->createQueryBuilder('c')
            ->select('c', 'b')
            ->join('c.book', 'b')
            ->getQuery()
            ->getArrayResult();

        if ($request->isXmlHttpRequest()) {
            return $this->json($categories);
        } else {

        }
    }
}
