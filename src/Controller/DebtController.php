<?php

namespace App\Controller;

use App\Entity\Debt;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller
 * @Route("/debt")
 */
class DebtController extends BaseController
{
    /**
     * @Route("/", name="debt_list", methods="GET")
     */
    public function index(Request $request): Response
    {
        $debts = $this->getDoctrine()->getRepository(Debt::class)
            ->createQueryBuilder('d')
            ->getQuery()
            ->getArrayResult();

        if ($request->isXmlHttpRequest()) {
            return $this->json($debts);
        }
    }
}
