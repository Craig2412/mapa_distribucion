<?php

namespace App\Domain\Mayoristas\Service;

use App\Domain\Mayoristas\Repository\MayoristasRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class MayoristasValidator
{
    private MayoristasRepository $repository;

    public function __construct(MayoristasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateMayoristasUpdate(int $mayoristassId, array $data): void
    {
        if (!$this->repository->existsMayoristasId($mayoristassId)) {
            throw new DomainException(sprintf('Mayoristas not found: %s', $mayoristassId));
        }

        $this->validateMayoristas($data);
    }

    public function validateMayoristas(array $data): void
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
                'mayoristas' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5, 30)
                    ]
                )
            ]
        );
    }
}
