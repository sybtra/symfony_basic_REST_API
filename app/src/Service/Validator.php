<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {
    }
    public function validateEntity(object $entity)
    {
        $validationErrors = $this->validator->validate($entity);

        if (count($validationErrors) > 0) {
            $errors = [];
            foreach ($validationErrors as $error) {
                $errors[] = $error->getMessage();
            }
            return [
                'errors' => $errors
            ];
        }

        return [
            'errors' => []
        ];
    }
}
