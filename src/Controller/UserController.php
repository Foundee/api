<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * Register new user
     *
     * @Route("/users", methods={"POST"}, name="users_registration")
     *
     * @SWG\Parameter(
     *     name="username",
     *     in="query",
     *     type="string",
     *     required=true,
     * )
     * @SWG\Parameter(
     *     name="email",
     *     in="query",
     *     type="string",
     *     required=true,
     * )
     * @SWG\Parameter(
     *     name="password",
     *     in="query",
     *     type="string",
     *     required=true,
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="User successfully created",
     *     @SWG\Schema(type="object", example={"success":true})
     * )
     * @SWG\Tag(name="users")
     */
    public function registration(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRegisterIp($request->getClientIp());
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->json(['success' => true], Response::HTTP_CREATED);
        }

        return $this->json(['success' => false], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
