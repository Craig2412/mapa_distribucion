<?php

namespace App\Domain\Categorias\Service;

use App\Domain\Categorias\Repository\CategoriasRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class CategoriasCreator
{
    private CategoriasRepository $repository;

    private CategoriasValidator $categoriasValidator;

    private LoggerInterface $logger;

    public function __construct(
        CategoriasRepository $repository,
        CategoriasValidator $categoriasValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->categoriasValidator = $categoriasValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('categorias_creator.log')
            ->createLogger();
    }

    public function createCategorias(array $data): int
    {   
        function obtener_ip_real() {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
              return $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
              return $_SERVER['REMOTE_ADDR'];
            }
          }
          
        $ip_cliente = obtener_ip_real();
        $data["user_requests_ip"] = $ip_cliente;

          // Input validation
        $this->categoriasValidator->validateCategorias($data);
        // Insert categorias and get new categorias ID
        $categoriasId = $this->repository->insertCategorias($data);

        // Logging
        $this->logger->info(sprintf('Visita created successfully: %s', $categoriasId));

        return $categoriasId;
    }
}
