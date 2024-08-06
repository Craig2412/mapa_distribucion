<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Condiciones extends AbstractMigration
{
    public function change(): void
    {
        $condiciones = $this->table('condiciones');
        $condiciones->addColumn('condicion', 'string', ['limit' => 50])
                    ->create();
    }
}
