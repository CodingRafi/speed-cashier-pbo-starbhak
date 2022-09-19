<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::unprepared('CREATE TRIGGER count_transaksi AFTER INSERT ON `pesanans` FOR EACH ROW
        //         BEGIN
        //            UPDATE `transaksis` SET `total_harga` = (OLD.total_harga) + (NEW.)
        //         END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::unprepared('DROP TRIGGER `count_transaksi`');
    }
};
