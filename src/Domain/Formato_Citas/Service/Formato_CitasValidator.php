<?php

namespace App\Domain\Formato_Citas\Service;

use App\Domain\Formato_Citas\Repository\Formato_CitasRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class Formato_CitasValidator
{
    private Formato_CitasRepository $repository;

    public function __construct(Formato_CitasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateFormato_CitasUpdate(int $formato_citasId, array $data): void
    {
        if (!$this->repository->existsFormato_CitasId($formato_citasId)) {
            throw new DomainException(sprintf('Formato_Citas not found: %s', $formato_citasId));
        }

        $this->validateFormato_Citas($data);
    }

    public function validateFormato_Citas(array $data): void
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
                'formato_cita' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5, 30)
                    ]
                )          
            ]
        );
    }
}
