<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class QueryHelper
{
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}
    
    /**
     * findObjectByAttr
     *
     * @param  mixed $value
     * @param  string $attribute
     * @param  string $entityClass
     * @return object
     */
    public function findObjectByAttr($value, string $attribute, string $entityClass)
    {
        $existingObject = $this->entityManager->getRepository($entityClass)->findOneBy([$attribute => $value]);
        return $existingObject ?: false;
    }
}
