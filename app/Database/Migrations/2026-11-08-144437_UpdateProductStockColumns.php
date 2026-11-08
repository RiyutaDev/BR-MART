<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateProductStockColumns extends Migration
{
    public function up()
    {
        // Ubah nama kolom stock menjadi stock_on_hand
        $this->forge->modifyColumn('products', [
            'stock' => [
                'name'     => 'stock_on_hand',
                'type'     => 'INT',
                'unsigned' => true,
                'default'  => 0,
            ],
        ]);

        // Tambahkan kolom stok yang dicadangkan
        $this->forge->addColumn('products', [
            'stock_reserved' => [
                'type'     => 'INT',
                'unsigned' => true,
                'default'  => 0,
                'after'    => 'stock_on_hand',
            ],
        ]);
    }

    public function down()
    {
        // Hapus kolom stock_reserved
        $this->forge->dropColumn('products', 'stock_reserved');

        // Kembalikan nama stock_on_hand menjadi stock
        $this->forge->modifyColumn('products', [
            'stock_on_hand' => [
                'name'     => 'stock',
                'type'     => 'INT',
                'unsigned' => true,
                'default'  => 0,
            ],
        ]);
    }
}
