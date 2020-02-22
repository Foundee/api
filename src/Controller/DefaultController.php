<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * Default test method
     *
     * @Route("/", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="API work well"
     * )
     * @SWG\Tag(name="default")
     */
    public function index(): Response
    {
        return $this->json([]);
    }
}
