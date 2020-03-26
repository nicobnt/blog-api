<?php

namespace App\Controller;

use App\Entity\Article;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController
 * @package App\Controller
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="article_create", methods={"POST"}, )
     *
     * @param Request $request
     * @param SerializerInterface $serializable
     *
     * @return Response
     *
     */
    public function create(Request $request, SerializerInterface $serializer): Response
    {
        $data = $request->getContent();
        $article = $serializer->deserialize($data, "App\Entity\Article", "json");

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return new Response('Article created', Response::HTTP_CREATED);
    }

    /**
     * @Route("/articles/{id}", name="article_show", methods={"GET"}, requirements={"id"="\d+"})
     * @param int $id
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function show(int $id, SerializerInterface $serializer): Response{

        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $data = $serializer->serialize($article, "json");

        $response = New Response($data);
        $response->headers->set("Content-Type", "application/json");

        return $response;
    }

    /**
     * @Route("/articles", name="article", methods={"GET"})
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function list(SerializerInterface $serializer): Response{

        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        $data = $serializer->serialize($articles, "json");

        $response = New Response($data);
        $response->headers->set("Content-Type", "application/json");

        return $response;
    }
}