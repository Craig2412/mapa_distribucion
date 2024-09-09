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
            throw new ValidationFailedException('Varificar Datos', $violations);
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
                                $constraint->length(2,150)
                            ]
                            ),
                        'apellidos' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->length(1,150)
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
            
            case '2':
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
                break;


            case '3':
                return $constraint->collection(
                    [
                        'id_datos_generales' => $constraint->required(
                            [
                                $constraint->notBlank(),
                                $constraint->positive(),
                                $constraint->length(1,11)
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
                                $constraint->length(0,3)
                            ]
                            ),
                        'capacidad_almacenamiento' => $constraint->required(
                            [
                                $constraint->length(0,7)
                            ]
                            ),
                        'capacidad_almacenamiento_frio' => $constraint->required(
                            [
                                $constraint->length(0,7)
                            ]
                            ),
                        'tamaño_infraestructura' => $constraint->required(
                            [
                                $constraint->length(0,7)
                            ]
                            ),
                        'precio_volumen' => $constraint->required(
                            [
                                $constraint->length(0,100)
                            ]
                            ),
                        'frecuencia_reposicion' => $constraint->required(
                            [
                                $constraint->length(0,40)
                            ]
                            ),
                        'cantidad_trabajadores_directos' => $constraint->required(
                            [
                                $constraint->length(0,7)
                            ]
                            ),
                        'volumen_mensual_comercializacion_mercancia' => $constraint->required(
                            [
                                $constraint->length(0,10)
                            ]
                            ),
                        'flota_vehicular' => $constraint->required(
                            [
                                $constraint->length(0,7)
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
