<?php

namespace App\Domain\Empresas\Service;

use App\Domain\RepresentanteLegal\Repository\RepresentanteLegalRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class EmpresasValidator
{
    private RepresentanteLegalRepository $repository;

    public function __construct(RepresentanteLegalRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateRepresentanteLegalUpdate(int $representanteLegalsId, array $data): void
    {
        $this->validateRepresentanteLegal($data);
    }

    public function validateRepresentanteLegal(array $data): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($data, $this->createConstraints());

        if ($violations->count()) {
            throw new ValidationFailedException('Varificar Datos', $violations);
        }
    }

    private function createConstraints(): Constraint
    {
        $constraint = new ConstraintFactory();

        return $constraint->collection(
            [
               'razon_social' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(3,100)
                    ]
                    ),
                'coordenadas_x' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,300)
                    ]
                    ),
                'coordenadas_y' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,300)
                    ]
                    ),
                'rif' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,15)
                    ]
                    ),
                
                'id_estado' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                        $constraint->length(1,3)
                    ]
                    ),
                'id_municipio' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,5)
                    ]
                    ),
                'id_parroquia' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,5)
                    ]
                    ),
                'id_representante_legal' => $constraint->required(
                    [
                        $constraint->positive(),
                        $constraint->notBlank(),
                        $constraint->length(1,5)
                    ]
                    ),
                'telefono' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                        $constraint->length(1,11)
                    ]
                    ),
                'correo' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->email(),
                        $constraint->length(8,200)
                    ]
                    ),
                
                'sector' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                        $constraint->length(1,150)
                    ]
                    ),
                'sub_sector' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                        $constraint->length(1,150)
                    ]
                )
            ]
        );
    }
}
