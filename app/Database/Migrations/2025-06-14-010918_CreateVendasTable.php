<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVendasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'vendas_id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'vendas_clientes_id' => [
                'type' => 'INT',
                'null' => false,
            ],
            'vendas_funcionarios_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'vendas_data' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'vendas_total' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
            ],
            'vendas_status' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'default' => 'Pendente',
            ],
        ]);

        $this->forge->addKey('vendas_id', true);

        // Se quiser adicionar FK, faça aqui (supondo que clientes e funcionarios existam)
        $this->forge->addForeignKey('vendas_clientes_id', 'clientes', 'clientes_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('vendas_funcionarios_id', 'funcionarios', 'funcionarios_id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('vendas');
    }

    public function down()
    {
        $this->forge->dropTable('vendas');
    }
}
