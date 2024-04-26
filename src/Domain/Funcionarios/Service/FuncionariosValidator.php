<?php

namespace App\Domain\Funcionarios\Service;

use App\Domain\Funcionarios\Repository\FuncionariosRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class FuncionariosValidator
{
    private FuncionariosRepository $repository;

    public function __construct(FuncionariosRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateFuncionariosUpdate(int $funcionariossId, array $data): void
    {
        if (!$this->repository->existsFuncionariosId($funcionariossId)) {
            throw new DomainException(sprintf('Funcionarios not found: %s', $funcionariossId));
        }

        $this->validateFuncionarios($data);
    }

    public function validateFuncionarios(array $data): void
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
                'cedula' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                        $constraint->length(6, 10),
                    ]
                    ),
                'apellidos_nombres' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(10,250),
                    ]
                ),
                'telefono' => $constraint->required(
                    [
                        $constraint->length(null,11)
                    ]
                ),
                'correo' => $constraint->required(
                    [
                        $constraint->length(null, 200)
                    ]
                ),
                'serial_carnet' => $constraint->required(
                    [
                        $constraint->length(null,10)
                    ]
                ),
                'codigo_carnet' => $constraint->required(
                    [
                        $constraint->length(null,10)
                    ]
                ),
                'estado' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(3,250),
                    ]
                ),
                'municipio' => $constraint->required(
                    [
                        $constraint->length(3,250),
                    ]
                ),
                'localidad' => $constraint->required(
                    [
                        $constraint->length(3,250),
                    ]
                ),
                'nombre_centro_votacion' => $constraint->required(
                    [
                        $constraint->length(3,250),
                    ]
                )
            ]
        );
    }
}
