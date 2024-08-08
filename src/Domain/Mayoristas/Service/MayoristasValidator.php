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

    public function validateMayoristas(array $data, int $paso): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($data, $this->createConstraints($paso));

        if ($violations->count()) {
            throw new ValidationFailedException('Please check your input', $violations);
        }
    }

    private function createConstraints($paso): Constraint
    {
        $constraint = new ConstraintFactory();
        
        switch ($paso) {
            case '1':
                return $constraint->collection(
                    [
                        'nombres' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->length(3,100)
                            ]
                            ),
                        'apellidos' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->length(1,100)
                            ]
                            ),
                        'identificacion' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->positive(),
                                $constraint->length(1,10)
                            ]
                            ),
                        'correo' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->email(),
                                $constraint->length(1,200)
                            ]
                            ),
                        
                        'telefono' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->positive(),
                                $constraint->length(10,11)
                            ]
                        )
                    ]
                );
                break;
            case '3':
                return $constraint->collection(
                    [
                        'id_datos_generales' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->positive(),
                                $constraint->length(1,3)
                            ]
                            ),
                        'id_tipo_mayorista' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->positive(),
                                $constraint->length(1,3)
                            ]
                            ),
                        'cantidad_locales_comerciales' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->length(1,3)
                            ]
                            ),
                        'capacidad_almacenamiento' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->length(1,7)
                            ]
                            ),
                        'capacidad_almacenamiento_frio' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->length(1,7)
                            ]
                            ),
                        'tamaño_infraestructura' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->length(1,7)
                            ]
                            ),
                        'precio_volumen' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->length(1,100)
                            ]
                            ),
                        'frecuencia_reposicion' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->length(1,40)
                            ]
                            ),
                        'cantidad_trabajadores_directos' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->length(1,7)
                            ]
                            ),
                        'volumen_mensual_comercializacion_mercancia' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->length(1,10)
                            ]
                            ),
                        'flota_vehicular' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->length(1,7)
                            ]
                        )
                    ]
                );
                break;
            
            default:
                # code...
                break;
        }

        
        
    }
}
