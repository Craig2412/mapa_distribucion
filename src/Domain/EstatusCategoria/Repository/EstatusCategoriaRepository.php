<?php

namespace App\Domain\EstatusCategoria\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class EstatusCategoriaRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
   
    public function getEstatusCategoriaById(int $estatusCategoriasId): array
    {
        $query = $this->queryFactory->newSelect('estatus_categorias');
        $query->select(
            [
                'estatus_categorias.id',
                'estatus_categorias.estatus_categoria',
                'estatus_categorias.id_categoria',
                'categorias.categoria',
                'estatus_categorias.created',
                'estatus_categorias.updated'
            ]

        )
        ->leftjoin(['categorias'=>'categorias'], 'categorias.id = estatus_categorias.id_categoria');

        $query->where(['estatus_categorias.estatus_categoria'=> $estatusCategoriasId]);
            
            $row = $query->execute()->fetch('assoc');
            
            if (!$row) {
                throw new DomainException(sprintf('EstatusCategoria no encontrados: %s', $estatusCategoriasId));
        }
        
        return $row;
    }
    

    public function existsEstatusCategoriaId(int $estatusCategoriasId): bool
    {
        $query = $this->queryFactory->newSelect('estatus_categorias');
        $query->select('id')->where(['id' => $estatusCategoriasId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    
}
