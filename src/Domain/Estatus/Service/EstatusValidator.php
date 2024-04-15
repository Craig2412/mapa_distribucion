<?php

namespace App\Domain\Estatus\Service;

use App\Domain\Estatus\Repository\EstatusRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class EstatusValidator
{
    private EstatusRepository $repository;

    public function __construct(EstatusRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateEstatusUpdate(int $estatussId, array $data): void
    {
        if (!$this->repository->existsEstatusId($estatussId)) {
            throw new DomainException(sprintf('Estatus not found: %s', $estatussId));
        }

        $this->validateEstatus($data);
    }

    public function validateEstatus(array $data): void
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
                'estatus' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5, 30)
                    ]
                )
            ]
        );
    }
}
