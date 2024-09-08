<?php

namespace App\Domain\Bufete\Service;

use App\Domain\Bufete\Repository\BufeteRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class BufeteValidator
{
    private BufeteRepository $repository;

    public function __construct(BufeteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateBufeteUpdate(int $bufeteId, array $data): void
    {
        if (!$this->repository->existsBufeteId($bufeteId)) {
            throw new DomainException(sprintf('Bufete not found: %s', $bufeteId));
        }

        $this->validateBufete($data);
    }

    public function validateBufete(array $data): void
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
                'nombre_bufete' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(null, 100),
                    ]
                ),
                'correo' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->email(),
                        $constraint->length(10, 100),
                    ]
                ),
                'telefono' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->length(11, 11),
                    ]
                ),
                
                'rif' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(8, 15)
                    ]
                )
            ]
        );
    }
}
