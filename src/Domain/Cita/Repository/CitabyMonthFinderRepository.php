<?php

namespace App\Domain\Cita\Repository;

use App\Factory\QueryFactory;


final class CitabyMonthFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findCitabyMonth(int $year): array
    {
        
        $query = $this->queryFactory->newSelect('agents');
        $query->select([
            'extract(\'MONTH\' FROM agents.created) AS month', // No quotes
            'COUNT(agents.id) AS total'
        ])
        ->where(['extract(\'YEAR\'FROM"agents"."created") ' => $year,])
        ->group(['month']);

        $results = $query->execute()->fetchAll('assoc');
        
        $months = range(1, 12); // Genera un array con los números de mes del 1 al 12
        
        $formattedResults = [];
        
        foreach ($months as $month) {
            $formattedResults[] = [
                'month' => $month,
                'total' => 0
            ];
        }
        
        foreach ($results as $result) {
            $formattedResults[$result['month'] - 1] = $result;
        }
        
        //var_dump($formattedResults);
        
        return $formattedResults;
    }
}
