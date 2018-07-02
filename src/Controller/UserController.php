<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
<<<<<<< HEAD
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
=======
>>>>>>> a3658a373854a9c93bc392c5cfd8ec4cc8117889

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
<<<<<<< HEAD
     * @param Request $request
     * @param TranslatorInterface $translation
     * @param ValidatorInterface $validator
     * @return JsonResponse
     *
     * Check if email is registered.
     */
    public function checkEmail(
        Request $request,
        TranslatorInterface $translation,
        ValidatorInterface $validator
    ): JsonResponse
=======
     * Check if email is registered.
     */
    public function checkEmail(Request $request): JsonResponse
>>>>>>> a3658a373854a9c93bc392c5cfd8ec4cc8117889
    {
        $email = $request->query->get('email');

        if (!isset($email)) {
<<<<<<< HEAD
            return $this->json(
                [
                    'success' => false,
                    'message' => $translation->trans('error.variable.empty')
=======
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => 'Empty required variable'
>>>>>>> a3658a373854a9c93bc392c5cfd8ec4cc8117889
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

<<<<<<< HEAD
        $errorCount = $validator->validate($email, new Assert\Email([]));

        if (0 < count($errorCount)) {
            return $this->json(
                [
                    'success' => false,
                    'message' => $translation->trans('error.email.bad')
=======
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => 'Your email contains special chars'
>>>>>>> a3658a373854a9c93bc392c5cfd8ec4cc8117889
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $entityManager = $this->getDoctrine()->getManager()->getRepository(User::class);
        $findEmail = $entityManager->findBy(['email' => $email]);

        if ($findEmail) {
<<<<<<< HEAD
            return $this->json(
                [
                    'success' => false,
                    'message' => $translation->trans('error.record.exists')
=======
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => 'This email exists in our db.'
>>>>>>> a3658a373854a9c93bc392c5cfd8ec4cc8117889
                ],
                JsonResponse::HTTP_FOUND
            );
        }

<<<<<<< HEAD
        return $this->json(
=======
        return new JsonResponse(
>>>>>>> a3658a373854a9c93bc392c5cfd8ec4cc8117889
            [
                'success' => true
            ],
            JsonResponse::HTTP_OK
        );
    }

    /**
<<<<<<< HEAD
     * @param Request $request
     * @param TranslatorInterface $translation
     * @param ValidatorInterface $validator
     * @return JsonResponse
     *
     * Check if login is registered
     */
    public function checkLogin(
        Request $request,
        TranslatorInterface $translation,
        ValidatorInterface $validator
    ): JsonResponse
=======
     * Check if login is registered
     */
    public function checkLogin(Request $request): JsonResponse
>>>>>>> a3658a373854a9c93bc392c5cfd8ec4cc8117889
    {
        $login = $request->query->get('login');

        if (!isset($login)) {
<<<<<<< HEAD
            return $this->json(
                [
                    'success' => false,
                    'message' => $translation->trans('error.variable.empty')
=======
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => 'Empty required variable'
>>>>>>> a3658a373854a9c93bc392c5cfd8ec4cc8117889
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $entityManager = $this->getDoctrine()->getManager()->getRepository(User::class);
        $findLogin = $entityManager->findBy(['username' => $login]);

        if ($findLogin) {
<<<<<<< HEAD
            return $this->json(
                [
                    'success' => false,
                    'message' => $translation->trans('error.record.exists')
=======
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => 'This login exists in our db.'
>>>>>>> a3658a373854a9c93bc392c5cfd8ec4cc8117889
                ],
                JsonResponse::HTTP_FOUND
            );
        }

<<<<<<< HEAD
        return $this->json(
=======
        return new JsonResponse(
>>>>>>> a3658a373854a9c93bc392c5cfd8ec4cc8117889
            [
                'success' => true
            ],
            JsonResponse::HTTP_OK
        );
    }
}
