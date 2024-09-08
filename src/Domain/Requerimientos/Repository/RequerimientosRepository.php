<?php

namespace App\Domain\Requerimientos\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class RequerimientosRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;

    }

    public function insertRequerimientos(array $requerimientos): int
    {
        $validate = $this->existsRequerimientosId($requerimientos["agent_identification"], $requerimientos["agent_rif"]);
        $validateAgent = $this->existsRequerimientosIdAgent($requerimientos["agent_number"]);
        if ($validate) {
            throw new DomainException(sprintf('Identificación o rif de agente ya registrado'));
        }else if($validateAgent){
            throw new DomainException(sprintf('Número de agente ya registrado'));
        }else{
            return (int)$this->queryFactory->newInsert('agents', $this->toRow($requerimientos))
            ->execute()
            ->lastInsertId();
        }
        
    }

    public function getRequerimientosById(int $requerimientosId): array
    {
        $query = $this->queryFactory->newSelect('agents');
        $query->select(
            [
                '*',
            ]
        )

        ->leftjoin(['b'=>'type_agent'], 'agents.agent_type = b.id')
        ->leftjoin(['c'=>'direcction'], 'agents.id = c.direcction_id_agent')
        ->leftjoin(['d'=>'estados'], 'c.direcction_estado = d.id_estado')
        ->leftjoin(['e'=>'municipios'], 'c.direcction_municipio = e.id_municipio')
        ->leftjoin(['f'=>'parroquias'], 'c.direcction_parroquia = f.id_parroquia');

        $query->where(['agents.id' => $requerimientosId]);


        $row = $query->execute()->fetch('assoc');
        //var_dump($row);

        if (!$row) {
            throw new DomainException(sprintf('Requerimientos not found: %s', $requerimientosId));
        }

        return $row;
    }

    public function updateRequerimientos(int $requerimientosId, array $requerimientos): array
    {
        $row = $this->toRowUpdate($requerimientos);

        $this->queryFactory->newUpdate('requerimientos', $row)
            ->where(['id' => $requerimientosId])
            ->execute();
        return $row;
    }

    public function existsRequerimientosId(string $requerimientosId, string $rif): bool
    {
        $query = $this->queryFactory->newSelect('agents');
        $query->select('id')->where([
            'OR' => [
                'agent_identification' => $requerimientosId,
                'agent_rif' => $rif
            ]
        ]);

        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function existsRequerimientosIdAgent(string $requerimientosIdAgent): bool
    {
        $query = $this->queryFactory->newSelect('agents');
        $query->select('id')->where(['agent_number' => $requerimientosIdAgent]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteRequerimientosById(int $requerimientosId): void
    {
        $this->queryFactory->newDelete('requerimientos')
            ->where(['id' => $requerimientosId])
            ->execute();
    }

    private function toRow(array $requerimientos): array
    {
        return [
            'agent_name' => $requerimientos['agent_name'],
            'agent_lastname' => $requerimientos['agent_lastname'],
            'agent_identification' => $requerimientos['agent_identification'],
            'agent_rif' => $requerimientos['agent_rif'],
            'agent_gender' => $requerimientos['agent_gender'],
            'agent_type' => $requerimientos['agent_type'],
            'agent_number_type' => $requerimientos['agent_number_type'],
            'agent_telefone' => $requerimientos['agent_telefone'],
            'agent_telefone_alternative' => $requerimientos['agent_telefone_alternative'],
            'agent_email' => $requerimientos['agent_email'],
            'agent_email_alternative' => $requerimientos['agent_email_alternative'],
            'agent_number' => $requerimientos['agent_number'],
            'agent_date_inscription' => $requerimientos['agent_date_inscription'],
            'agent_management' => $requerimientos['agent_management'],
            'id_condition' => 1,
            'created' => $this->fecha

        ];
    }

    private function toRowUpdate(array $requerimientos): array
    {
        return [
            'id_formato_cita' => $requerimientos['id_formato_cita'],
            'id_condicion' => $requerimientos['id_condicion'],
            'id_estado' => $requerimientos['id_estado'],
            'id_estado_pais' => $requerimientos['id_estado_pais'],
            'id_pais' => $requerimientos['id_pais'],
            'id_trabajador' => $requerimientos['id_trabajador'],
            'updated' => $this->fecha
        ];
    }
} 