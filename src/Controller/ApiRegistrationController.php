<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\QueryHelper;
use App\Service\EntityUpsert;
use App\Exception\AppException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

/**
 * ApiRegistrationController handles registration-related actions.
 */
class ApiRegistrationController extends AbstractController
{
    /**
     * ApiRegistrationController constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param QueryHelper $queryHelper
     * @param EntityUpsert $entityUpsert
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private QueryHelper $queryHelper,
        private EntityUpsert $entityUpsert,
    ) {
    }
    #[Route('/register', name: 'register_user', methods: 'POST')]
    /**
     * Register new User
     *
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register new User",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             required={"login", "password", "email", "firstname", "lastname"},
     *             @OA\Property(property="login", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="firstname", type="string"),
     *             @OA\Property(property="lastname", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User registered successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Conflict - A user with the same login already exists",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="A user with the same login already exists")
     *         )
     *     )
     * )
     * @param  Request $request
     * @param  UserPasswordHasherInterface $passwordHasher
     * @return JsonResponse
     */
    public function registration(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = new User();

        if ($this->queryHelper->findObjectByAttr($data['login'], 'login', User::class)) {
            throw new AppException('A user with the same login already exists', 409);
        } else {
            $uniqueAttributes = ['login'];
            $this->entityUpsert->upsertObject($user, $data, $uniqueAttributes);

            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $response = [
                'data' => ['message' => 'User registered successfully'],
                'status' => 201
            ];
        }

        return $this->json($response['data'], $response['status']);
    }
}
