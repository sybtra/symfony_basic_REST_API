<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\EntityUpsert;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private EntityManagerInterface $entityManager,
        private EntityUpsert $entityUpsert,
    ) {
    }
    #[Route('/users', name: 'display_current_user', methods: 'GET')]
    public function currentUserInfo(): JsonResponse
    {
        $serializedUser = $this->serializer->serialize($this->getUser(), 'json', ['groups' => 'public']);
        return JsonResponse::fromJsonString($serializedUser);
    }
    #[Route('/users', name: 'update_current_user', methods: 'PUT')]
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
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->json(['message' => 'User updated successfully. Password changed, please log in again.'], 200);
        }

        return $this->json(['message' => 'User updated successfully'], 200);
    }
}
