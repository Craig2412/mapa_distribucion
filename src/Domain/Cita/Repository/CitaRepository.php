<?php

namespace App\Domain\Cita\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class CitaRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }

    public function insertCitas(array $cita): int
    {
        return (int)$this->queryFactory->newInsert('direcction', $this->toRow($cita))
            ->execute()
            ->lastInsertId();
    }

    public function getCitaById(int $citaId): array
    {
        $query = $this->queryFactory->newSelect('citas');
        $query->select(
            [
                'citas.id',
                'citas.fecha_cita',
                'citas.id_requerimiento',
                'citas.id_estado',
                'estados.estado',
                'citas.id_formato_cita',
                'formato_citas.formato_cita',
                'citas.id_condicion',
                'citas.created',
                'citas.updated'
            ]
        )
        ->leftjoin(['estados'=>'estados'], 'estados.id = citas.id_estado')
        ->leftjoin(['formato_citas'=>'formato_citas'], 'formato_citas.id = citas.id_formato_cita'); 
        
        $query->where(['citas.id_condicion' => 1,'citas.id' => $citaId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Citas not found: %s', $citaId));
        }
        return $row;
    }


    public function getCitabyRequerimientoById(int $citaId): array
    {
        $query = $this->queryFactory->newSelect('citas');
        $query->select(
            [
                'citas.id',
                'citas.fecha_cita',
                'citas.id_requerimiento',
                'citas.id_estado',
                'estados.estado',
                'citas.id_formato_cita',
                'formato_citas.formato_cita',
                'citas.id_condicion',
                'citas.created',
                'citas.updated'
            ]
        )
        ->leftjoin(['estados'=>'estados'], 'estados.id = citas.id_estado')
        ->leftjoin(['formato_citas'=>'formato_citas'], 'formato_citas.id = citas.id_formato_cita'); 
        
        $query->where(['citas.id_condicion' => 1,'citas.id_requerimiento' => $citaId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Citas not found: %s', $citaId));
        }
        return $row;
    }

    public function updateCita(int $citaId, array $cita): array
    {
        $row = $this->toRowUpdate($cita);

        $this->queryFactory->newUpdate('citas', $row)
            ->where(['id' => $citaId])
            ->execute();
        return $row;
    }

    public function existsCitaId(int $citaId): bool
    {
        $query = $this->queryFactory->newSelect('citas');
        $query->select('id')->where(['id' => $citaId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteCitaById(int $citaId): void
    {
        $this->queryFactory->newDelete('citas')
            ->where(['id' => $citaId])
            ->execute();
    }

    private function toRow(array $cita): array
    {
        
        return [
            'direcction_name' => $cita['direcction_name'],
            'direcction_estado' => $cita['direcction_estado'],
            'direcction_municipio' => $cita['direcction_municipio'],
            'direcction_parroquia' => $cita['direcction_parroquia'],
            'direcction_lat' => $cita['direcction_lat'],
            'direcction_lng' => $cita['direcction_lng'],
            'direcction_id_agent' => $cita['direcction_id_agent'],
            'id_condition' => 1,
            'created' => $this->fecha
        ];
    }

    private function toRowUpdate(array $cita): array
    {
        return [
            'fecha_cita' => $cita['fecha_cita'],
            'id_estado' => $cita['id_estado'],
            'id_formato_cita' => $cita['id_formato_cita'],
            'updated' => $this->fecha
        ];
    }
}
