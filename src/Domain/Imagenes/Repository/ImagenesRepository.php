<?php

namespace App\Domain\Imagenes\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class ImagenesRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 18000); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;
    }
    
    public function insertImagenes(array $imagenes): int
    {
        
        return (int)$this->queryFactory->newInsert('imagenes', $this->toRow($imagenes))
        ->execute()
        ->lastInsertId();
    }

    public function insertImagenesAsignacion(array $imagenes): int
    {
        return (int)$this->queryFactory->newInsert('img_mayorista', $this->toRow($imagenes))
        ->execute()
        ->lastInsertId();
    }
    
    public function getImagenesById(int $imagenesId): array
    {
        $query = $this->queryFactory->newSelect('imagenes');
        $query->select(
                [
                    'imagenes.id',
                    'url',
                    'id_img'
                ]
            )->innerjoin(['m'=>'img_mayorista'], 'm.id_img = imagenes.id');
            
            $query->where(['m.id_mayorista' => $imagenesId]);
            
            $row = $query->execute()->fetchAll('assoc') ?: [];
            
            if (!$row) {
                throw new DomainException(sprintf('Imagenes not found: %s', $imagenesId));
        }
        
        return $row;
    }
    
    public function updateImagenes(int $imagenesId, array $imagenes): array
    {
        $row = $this->toRowUpdate($imagenes);
        
        $this->queryFactory->newUpdate('imagenes', $row)
        ->where(['id' => $imagenesId])
        ->execute();

        return $row;

    }

    public function existsImagenesId(int $imagenesId): bool
    {
        $query = $this->queryFactory->newSelect('imagenes');
        $query->select('id')->where(['id' => $imagenesId]);
        
        return (bool)$query->execute()->fetch('assoc');
    }
    
    public function deleteImagenesById(int $imagenesId): void
    {
        $this->queryFactory->newDelete('imagenes')
        ->where(['id_img' => $imagenesId])
        ->execute();
    }

    private function toRow(array $imagenes): array
    {        
        
        $array=[];
        foreach ($imagenes as $key => $value) {
            $array["$key"]=$value;
        }
        return $array;
    }

    private function toRowUpdate(array $imagenes): array
    {
        $array=[];
        foreach ($imagenes as $key => $value) {
            $array["$key"]=strtoupper($value);
        }
        return $array;
    }
}
