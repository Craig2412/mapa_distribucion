<?php

namespace App\Domain\Imagenes\Service;

use App\Domain\Imagenes\Repository\ImagenesRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class ImagenesValidatorUpdate
{
    private ImagenesRepository $repository;

    public function __construct(ImagenesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateImagenesUpdate(int $imagenesId, array $data): void
    {
        if (!$this->repository->existsImagenesId($imagenesId)) {
            throw new DomainException(sprintf('Imagenes not found: %s', $imagenesId));
        }

        $this->validateImagenes($data);
    }

    public function validateImagenes(array $data): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($data, $this->createConstraints());

        if ($violations->count()) {
            throw new ValidationFailedException('Please check your input', $violations);
        }
    }

    private function createConstraints(): Constraint
    {
        $constraint = new ConstraintFactory();

        return $constraint->collection(
            [
                'url' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->length(2, 100)
                    ]),
                    
                'id_mayorista' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                        $constraint->length(1,1000)
                    ]
                )
            ]
        );
    }
}
