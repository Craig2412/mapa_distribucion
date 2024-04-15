<?php

namespace App\Domain\Funcionarios\Service;

use App\Domain\Funcionarios\Repository\FuncionariosRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class FuncionariosValidatorUpdate
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
                        $constraint->length(6, 9),
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
                        $constraint->notBlank(),
                        $constraint->length(10,11),
                        $constraint->positive()
                    ]
                ),
                'correo' => $constraint->required(
                    [
                        $constraint->email(),
                        $constraint->length(7, 50)
                    ]
                ),
                'serial_carnet' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(10),
                        $constraint->positive()
                    ]
                ),
                'codigo_carnet' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(10),
                        $constraint->positive()
                    ]
                ),
                'estado' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5,250),
                    ]
                ),
                'municipio' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5,250),
                    ]
                ),
                'localidad' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5,250),
                    ]
                ),
                'nombre_centro_votacion' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5,250),
                    ]
                ),
                'id_estatus' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1),
                        $constraint->positive()
                    ]
                )
            ]
        );
    }
}
