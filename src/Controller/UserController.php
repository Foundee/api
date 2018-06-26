<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;

class UserController extends Controller
{
    /**
     * Register new user
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

        // TODO validation + refactor
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRegisterIp($request->getClientIp());
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->json(['success' => true], Response::HTTP_CREATED);
        }

        return $this->json(['success' => false], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Check if email is registered.
     */
    public function checkEmail(Request $request): JsonResponse
    {
        $email = $request->query->get('email');

        if (!isset($email)) {
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => 'Empty required variable'
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => 'Your email contains special chars'
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $entityManager = $this->getDoctrine()->getManager()->getRepository(User::class);
        $findEmail = $entityManager->findBy(['email' => $email]);

        if ($findEmail) {
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => 'This email exists in our db.'
                ],
                JsonResponse::HTTP_FOUND
            );
        }

        return new JsonResponse(
            [
                'success' => true
            ],
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Check if login is registered
     */
    public function checkLogin(Request $request): JsonResponse
    {
        $login = $request->query->get('login');

        if (!isset($login)) {
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => 'Empty required variable'
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $entityManager = $this->getDoctrine()->getManager()->getRepository(User::class);
        $findLogin = $entityManager->findBy(['username' => $login]);

        if ($findLogin) {
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => 'This login exists in our db.'
                ],
                JsonResponse::HTTP_FOUND
            );
        }

        return new JsonResponse(
            [
                'success' => true
            ],
            JsonResponse::HTTP_OK
        );
    }
}
