<?php

namespace App\Domain\Mensaje\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class MensajeRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;

    }

    public function insertMensaje(array $mensaje): int
    {
        return (int)$this->queryFactory->newInsert('mensajes', $this->toRow($mensaje))
            ->execute()
            ->lastInsertId();
    }

    public function getMensajeById(int $mensajeId): array
    {
        
        $query = $this->queryFactory->newSelect('areas');
        $query->select(
            [
                'areas.area_name',
                'COUNT(b.id) AS val'
            ]
        )
        ->leftjoin(['b'=>'areas_has_agents'], 'b.id_area = areas.id AND b.id_agent='.$mensajeId)
        ->group('areas.area_name');

        $row = $query->execute()->fetchAll('assoc') ?: [];

        if (!$row) {
            throw new DomainException(sprintf('Mensaje not found: %s', $mensajeId));
        }
        return $row;
    }

    public function updateMensaje(int $mensajeId, array $mensaje): array
    {
        $row = $this->toRowUpdate($mensaje);
        $row["updated"] = $this->fecha; 
        $this->queryFactory->newUpdate('mensajes', $row)
            ->where(['id' => $mensajeId])
            ->execute();
            return $row;
    }

    public function existsMensajeId(int $mensajeId): bool
    {
        $query = $this->queryFactory->newSelect('mensajes');
        $query->select('id')->where(['id' => $mensajeId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteMensajeById(int $mensajeId): void
    {
        $this->queryFactory->newDelete('mensajes')
            ->where(['id' => $mensajeId])
            ->execute();
    }

    private function toRow(array $mensaje): array
    { 
        return [
            'mensaje' => strtoupper($mensaje['mensaje']),
            'id_usuario' => $mensaje['id_usuario'],
            'id_solicitud' => $mensaje['id_solicitud'],
            'id_condicion' => 1,
            'created' => $this->fecha,
            'updated' => null
        ];
    }

    private function toRowUpdate(array $mensaje): array
    {        
        return [
            'mensaje' => strtoupper($mensaje['mensaje']),
            'id_condicion' => $mensaje['id_condicion'],
            'updated' => $this->fecha
        ];
    }
}