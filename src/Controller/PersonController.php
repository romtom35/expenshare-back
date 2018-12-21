<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\ShareGroup;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller
 * @Route("/person")
 */
class PersonController extends BaseController
{
    /**
     * @Route("/{slug}", name="person_list", methods="GET")
     */
    public function index(ShareGroup $group, Request $request): Response
    {
        $persons = $this->getDoctrine()->getRepository(Person::class)
            ->createQueryBuilder('p');

        $persons = $persons->select('p','e','s')
            ->join('p.expense', 'e')
            ->join('p.shareGroup', 's')
            ->where($persons->expr()->eq('s.slug', ':group'))
            ->setParameter(':group', $group->getSlug())
            ->getQuery()
            ->getArrayResult();

        if ($request->isXmlHttpRequest()) {
            return $this->json($persons);
        }
    }
    /**
     * @Route("/", name="person_new", methods="POST")
     */
    public function new(Request $request)
    {
        $data = $request->getContent();

        $jsonData = json_decode($data, true);
        $em = $this->getDoctrine()->getManager();

        $sharegroup = $em->getRepository(ShareGroup::class)->findOneBySlug($jsonData["slug"]);

        $person = new Person();
        $person->setFirstname($jsonData["firstname"]);
        $person->setLastname($jsonData["lastname"]);
        $person->setShareGroup($sharegroup);


        $em->persist($person);
        $em->flush();

        $pers = $this->getDoctrine()->getRepository(Person::class)
            ->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter(':id', $person->getId())
            ->getQuery()
            ->getArrayResult();

        return $this->json($pers[0]);
    }

    /**
     * @Route("/{id}", name="person_delete", methods="DELETE")
     */
    public function delete(Person $person)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($person);
        $em->flush();


        return $this->json(['ok' => true]);
    }
}
