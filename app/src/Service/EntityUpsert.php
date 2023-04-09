<?php

namespace App\Service;

use App\Exception\AppException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class EntityUpsert
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Validator $validator,
        private QueryHelper $queryHelper
    ) {
    }
    public function upsertObject(object $entity, array $data, array $uniqueAttributes = []): void
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        // Get the entity's short name
        $reflectionClass = new \ReflectionClass($entity);
        $entityShortName = $reflectionClass->getShortName();

        foreach ($data as $property => $value) {
            if ($propertyAccessor->isWritable($entity, $property)) {
                if (
                    $entityShortName === 'User' &&
                    $property === 'login' &&
                    $propertyAccessor->isReadable($entity, $property) &&
                    $propertyAccessor->getValue($entity, $property) === $data['login']
                ) {
                    // If the entity is a User and the login property is the same as the current value, skip the update
                    continue;
                }

                // Check if the property is unique and if it already exists in the database
                if (
                    in_array($property, $uniqueAttributes) &&
                    $this->queryHelper->findObjectByAttr($value, $property, get_class($entity))
                ) {
                    throw new AppException("A $entityShortName with the same $property already exists.", 409);
                }

                $propertyAccessor->setValue($entity, $property, $value);
            }
        }

        // Validate the updated entity
        $validationResult = $this->validator->validateEntity($entity);
        $errors = $validationResult['errors'];

        if (!empty($errors)) {
            throw new AppException(implode(', ', $errors), 422);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
