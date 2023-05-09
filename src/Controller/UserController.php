<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\EntityUpsert;
use App\Service\Helper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class UserController extends AbstractController
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EntityUpsert $entityUpsert,
        private Helper $helper,
    ) {
    }
    #[Route('/users', name: 'display_current_user', methods: 'GET')]
    /**
     * Display current user info
     *
     * @OA\Get(
     *     path="/api/users",
     *     summary="Display current user info",
     *     tags={"User"},
     *     @OA\Response(
     *         response=200,
     *         description="Current user info",
     *         @OA\JsonContent(ref=@Model(type=User::class, groups={"Default"}))
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Access Denied")
     *         )
     *     )
     * )
     * @return JsonResponse
     */
    public function currentUserInfo(): JsonResponse
    {
        return JsonResponse::fromJsonString(
            $this->helper->serializeGroupedPropertyObject($this->getUser())
        );
    }
    #[Route('/users', name: 'update_current_user', methods: 'PUT')]
    /**
     * User data update controller
     * @OA\Put(
     *     path="/api/users",
     *     summary="Update current user info",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="login", type="string", description="Optional, but required if included"),
     *             @OA\Property(property="password", type="string", description="Optional, only include if updating password, but required if included"),
     *             @OA\Property(property="email", type="string", format="email", description="Optional, but required if included"),
     *             @OA\Property(property="firstname", type="string", description="Optional, but required if included"),
     *             @OA\Property(property="lastname", type="string", description="Optional, but required if included")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Access Denied")
     *         )
     *     )
     * )
     * @param  Request $request
     * @param  UserPasswordHasherInterface $passwordHasher
     * @return JsonResponse
     */
    public function updateUserInfo(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
    ): JsonResponse {
        /** @var User $user */
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);
        $uniqueAttributes = ['login'];
        $this->entityUpsert->upsertObject($user, $data, $uniqueAttributes);

        if (isset($data['password'])) {
            $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
            $user->setPassword($hashedPassword);
            $this->entityUpsert->upsertObject($user);
        }

        return $this->json(['message' => 'User updated successfully']);
    }
}
