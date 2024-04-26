<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class EntidadesPrincipales extends AbstractMigration
{
    public function change(): void
    {
        $entidades_principales = $this->table('entidades_principales');
        $entidades_principales   ->addColumn('nombre_entidad_principal', 'string', ['limit' => 200])
                                 ->create();
    }
}
