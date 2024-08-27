<?php

namespace App\Domain\Cita\Service;

use App\Domain\Cita\Data\CitabyMonthFinderItem;
use App\Domain\Cita\Data\CitabyMonthFinderResult;
use App\Domain\Cita\Repository\CitabyMonthFinderRepository;

function obtenerNombreMes($numeroMes) {
    $meses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    ];

    if (isset($meses[$numeroMes])) {
        return $meses[$numeroMes];
    } else {
        return 'Tareas sin culminar';
    }
}

final class CitabyMonthFinder
{
    private CitabyMonthFinderRepository $repository;

    public function __construct(CitabyMonthFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findCitabyMonth(int $year): CitabyMonthFinderResult
    {
        // Input validation
        $citabyMonth = $this->repository->findCitabyMonth($year);

        return $this->createResult($citabyMonth);
    }

    private function createResult(array $citabyMonthRows): CitabyMonthFinderResult
    {
        $result = new CitabyMonthFinderResult();
        
        foreach ($citabyMonthRows as $citabyMonthRow) {
            $citabyMonth = new CitabyMonthFinderItem();
           
            $citabyMonth->month = obtenerNombreMes($citabyMonthRow['month']);
            $citabyMonth->total = $citabyMonthRow['total'];
            

            $result->citabyMonth[] = $citabyMonth;
        }
        
        return $result;
    }
}
