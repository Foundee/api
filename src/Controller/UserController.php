<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
     * @param Request $request
     * @param TranslatorInterface $translation
     * @param ValidatorInterface $validator
     * @return JsonResponse
     *
     * @SWG\Parameter(
     *     name="email",
     *     in="query",
     *     type="string",
     *     required=true,
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="Return true if email do not exists in db",
     *     @SWG\Schema(type="object", example={"success":true})
     * )
     *
     * Check if email is registered.
     */
    public function checkEmail(
        Request $request,
        TranslatorInterface $translation,
        ValidatorInterface $validator
    ): JsonResponse {
        $email = $request->query->get('email');

        if (!isset($email)) {
            return $this->json(
                [
                    'success' => false,
                    'message' => $translation->trans('error.variable.empty')
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $errorCount = $validator->validate($email, new Assert\Email());

        if (0 < count($errorCount)) {
            return $this->json(
                [
                    'success' => false,
                    'message' => $translation->trans('error.email.bad')
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $entityManager = $this->getDoctrine()->getManager()->getRepository(User::class);
        $findEmail = $entityManager->findBy(['email' => $email]);

        if ($findEmail) {
            return $this->json(
                [
                    'success' => false,
                    'message' => $translation->trans('error.record.exists')
                ],
                JsonResponse::HTTP_FOUND
            );
        }
        
        return $this->json(
            [
                'success' => true
            ],
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @param Request $request
     * @param TranslatorInterface $translation
     * @return JsonResponse
     *
     * @SWG\Parameter(
     *     name="login",
     *     in="query",
     *     type="string",
     *     required=true,
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="Return true if login do not exists in db",
     *     @SWG\Schema(type="object", example={"success":true})
     * )
     *
     * Check if login is registered
     */
    public function checkLogin(
        Request $request,
        TranslatorInterface $translation
    ): JsonResponse {
        $login = $request->query->get('login');

        if (!isset($login)) {
            return $this->json(
                [
                    'success' => false,
                    'message' => $translation->trans('error.variable.empty')
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $entityManager = $this->getDoctrine()->getManager()->getRepository(User::class);
        $findLogin = $entityManager->findBy(['username' => $login]);

        if ($findLogin) {
            return $this->json(
                [
                    'success' => false,
                    'message' => $translation->trans('error.record.exists')
                ],
                JsonResponse::HTTP_FOUND
            );
        }

        return $this->json(
            [
                'success' => true
            ],
            JsonResponse::HTTP_OK
        );
    }
    
    public function userInfo(
        Request $request,
        string $slug,
        TranslatorInterface $translation,
        SerializerInterface $serializer
    ): JsonResponse {
        $repository = $this->getDoctrine()->getManager()->getRepository(User::class);
        $entity = $repository->findBy(['id' => $slug]);
        
        if (!$entity) {
            $entity = $repository->findBy(['username' => $slug]);
        }
        
        if (!$entity) {
            return $this->json(
                [
                    'status' => false,
                    'message' => $translation->trans('error.record.empty')
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
        
        return $this->json(
            [
              'status' => true,
              'user' => $serializer->serialize($entity, ['groups' => ['user-basic-info']])
            ],
            JsonResponse::HTTP_FOUND
        );
    }
}
