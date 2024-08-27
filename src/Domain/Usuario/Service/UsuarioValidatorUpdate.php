<?php

namespace App\Domain\Usuario\Service;

use App\Domain\Usuario\Repository\UsuarioRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class UsuarioValidatorUpdate
{
    private UsuarioRepository $repository;

    public function __construct(UsuarioRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateUsuarioUpdate(int $usuarioId, array $data): void
    {
        if (!$this->repository->existsUsuarioId($usuarioId)) {
            throw new DomainException(sprintf('Usuario not found: %s', $usuarioId));
        }

        $this->validateUsuario($data);
    }

    public function validateUsuario(array $data): void
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
                'nombre' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(3,300),
                    ]
                ),
                'apellido' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(3,300),
                    ]
                ),
                'correo' => $constraint->required(
                    [
                        $constraint->email(),
                        $constraint->length(7, 50)
                    ]
                ),
                'identificacion' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(9,20)
                    ]
                ),
                'clave' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(7, 255)
                    ]
                ),
                'telefono' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(10,11),
                        $constraint->positive()
                    ]
                ),
                'id_rol' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,3),
                        $constraint->positive()
                    ]
                ),
                'id_condicion' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,2),
                        $constraint->positive()
                    ]
                )
            ]
        );
    }
}
