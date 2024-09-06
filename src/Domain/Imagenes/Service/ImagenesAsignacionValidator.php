<?php

namespace App\Domain\Imagenes\Service;

use App\Domain\Mayoristas\Repository\MayoristasRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class ImagenesAsignacionValidator
{
    private MayoristasRepository $repository;

    public function __construct(MayoristasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateImagenesAsignacionUpdate(int $imagenesAsignacionId, array $data): void
    {
        if (!$this->repository->existsMayoristasId($imagenesAsignacionId)) {
            throw new DomainException(sprintf('ImagenesAsignacion not found: %s', $imagenesAsignacionId));
        }

        $this->validateImagenesAsignacion($data);
    }

    public function validateImagenesAsignacion(array $data): void
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
                'id_mayorista' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                        $constraint->length(1, 1000)
                    ]
                ),
                'id_img' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                        $constraint->length(1, 1000)
                    ]
                )
            ]
        );
    }
}
