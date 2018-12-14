<?php

namespace App\Controller;

use App\Entity\Expense;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller
 * @Route("/expense")
 */
class ExpenseController extends BaseController
{
    /**
     * @Route("/", name="expense_list", methods="GET")
     */
    public function index(Request $request): Response
    {
        $persons = $this->getDoctrine()->getRepository(Expense::class)
            ->createQueryBuilder('e')
            ->getQuery()
            ->getArrayResult();

        if ($request->isXmlHttpRequest()) {
            return $this->json($persons);
        }
    }
}
