<?php

namespace App\Domain\Formato_Citas\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class Formato_CitasRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertFormato_Citas(array $formato_citas): int
    {
        return (int)$this->queryFactory->newInsert('formato_citas', $this->toRow($formato_citas))
        ->execute()
        ->lastInsertId();
    }
    
    public function getFormato_CitasById(int $formato_citasId): array
    {
        $query = $this->queryFactory->newSelect('signature');
        $query->select(
            [
                'signature.*',
            ]
        )->innerJoin('signature_has_agents', 'signature_has_agents.id_signature = signature.id');
        $query->where(['signature_has_agents.id_agent'=> $formato_citasId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('Formato_Citas no encontrados: %s', $formato_citasId));
        }
        
        return $row;
    }
    
    public function updateFormato_Citas(int $formato_citasId, array $formato_citas): array
    {
        $row = $this->toRow($formato_citas);
        
        $this->queryFactory->newUpdate('formato_citas', $row)
        ->where(['id' => $formato_citasId])
        ->execute();

        return $row;

    }

    public function existsFormato_CitasId(int $formato_citasId): bool
    {
        $query = $this->queryFactory->newSelect('formato_citas');
        $query->select('id')->where(['id' => $formato_citasId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteFormato_CitasById(int $formato_citasId): void
    {
        $this->queryFactory->newDelete('formato_citas')
        ->where(['id' => $formato_citasId])
        ->execute();
    }

    private function toRow(array $formato_citas): array
    {        
        return [
            'formato_cita' => strtoupper($formato_citas['formato_cita']),
        ];
    }
    
}
