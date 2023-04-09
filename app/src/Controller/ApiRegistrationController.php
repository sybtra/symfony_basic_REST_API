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

class ApiRegistrationController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private QueryHelper $queryHelper,
        private EntityUpsert $entityUpsert,
    ) {
    }
    #[Route('/register', name: 'register_user', methods: 'POST')]
    public function registration(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = new User();

        if ($this->queryHelper->findObjectByAttr($data['login'], 'login', User::class)) {
            throw new AppException('A user with the same login already exists.', 409);
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
