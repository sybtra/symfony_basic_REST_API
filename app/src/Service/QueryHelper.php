<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class QueryHelper
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function findObjectByAttr($value, string $attribute, string $entityClass)
    {
        $existingObject = $this->entityManager->getRepository($entityClass)->findOneBy([$attribute => $value]);
        return $existingObject ?: false;
    }
}
