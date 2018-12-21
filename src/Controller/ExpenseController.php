<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Expense;
use App\Entity\Person;
use App\Entity\ShareGroup;
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
     * @Route("/{slug}", name="expense_list", methods="GET")
     */
    public function index(ShareGroup $group, Request $request): Response
    {
        $expenses = $this->getDoctrine()->getRepository(Expense::class)
            ->createQueryBuilder('e');

        $expenses = $expenses->select('p','e','s')
            ->join('e.person', 'p')
            ->join('p.shareGroup', 's')
            ->where($expenses->expr()->eq('s.slug', ':group'))
            ->setParameter(':group', $group->getSlug())
            ->getQuery()
            ->getArrayResult();

        if ($request->isXmlHttpRequest()) {
            return $this->json($expenses);
        }
    }


    /**
     * @Route("/{id}", name="expense_udpate", methods="POST")
     */
    public function update(Expense $expense, Request $request)
    {
        $data = $request->getContent();

        $jsonData = json_decode($data, true);

        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository(Category::class)
            ->findOneById($jsonData["category"]);
        $person = $em->getRepository(Person::class)
            ->findOneById($jsonData["person"]);

        $expense->getId();
        $expense->setTitle($jsonData["title"]);
        $expense->setAmount($jsonData["amount"]);
        $expense->setCreatedAt(new \DateTime());
        $expense->setCategory($category);
        $expense->setPerson($person);

        $em->persist($expense);
        $em->flush();

        $exp = $this->getDoctrine()->getRepository(Expense::class)
            ->createQueryBuilder('e')
            ->where('e.id = :id')
            ->setParameter(':id', $expense->getId())
            ->getQuery()
            ->getArrayResult();

        return $this->json($exp[0]);
    }

    /**
     * @Route("/", name="expense_new", methods="POST")
     */
    public function new(Request $request)
    {
        $data = $request->getContent();

        $jsonData = json_decode($data, true);

        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository(Category::class)
            ->findOneById($jsonData["category"]);
        $person = $em->getRepository(Person::class)
            ->findOneById($jsonData["person"]);


        $expense = new Expense();
        $expense->setTitle($jsonData["title"]);
        $expense->setAmount($jsonData["amount"]);
        $expense->setCreatedAt(new \DateTime());
        $expense->setCategory($category);
        $expense->setPerson($person);


        $em->persist($expense);
        $em->flush();

        $exp = $this->getDoctrine()->getRepository(Expense::class)
            ->createQueryBuilder('e')
            ->where('e.id = :id')
            ->setParameter(':id', $expense->getId())
            ->getQuery()
            ->getArrayResult();

        return $this->json($exp[0]);

    }
    /**
     * @Route("/{id}", name="expense_delete", methods="DELETE")
     */
    public function delete(Expense $expense)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($expense);
            $em->flush();


        return $this->json(['ok' => true]);
    }
}
