<?php

namespace App\Controller;

use App\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AuthorController extends AbstractController
{
    /**
     * @Route("/authors/new", name="author_create", methods={"POST"}){
     *
     */

    public function create(Request $request, SerializerInterface $serializer) : Response
    {
        $data = $request->getContent();
        $author = $serializer->deserialize($data, "App\Entity\Author", 'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($author);
        $em->flush();

        return new Response('Author created', Response::HTTP_CREATED);
    }

    /**
     * @Route("/authors/{id}", name="author_show")
     */
    public function showAction(Author $author, SerializerInterface $serializer) : Response
    {
        $data =  $serializer->serialize($author, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}