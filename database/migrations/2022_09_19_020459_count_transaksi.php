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
        $procedure = "DROP PROCEDURE IF EXISTS `count_transaksi`;
            CREATE PROCEDURE `count_transaksi` (IN transaksi_id_params int)
            BEGIN

            UPDATE transaksis SET total_harga = (SELECT SUM(total_harga) FROM pesanans WHERE transaksi_id = transaksi_id_params) WHERE id = transaksi_id_params;

            END;";
  
        \DB::unprepared($procedure);
        \DB::unprepared('CREATE TRIGGER count_transaksi AFTER INSERT ON `pesanans` FOR EACH ROW
                BEGIN
                    CALL count_transaksi(new.transaksi_id);
                END');

        \DB::unprepared('CREATE TRIGGER change_status AFTER INSERT ON `transaksis` FOR EACH ROW
        BEGIN
            UPDATE `mejas` SET `status` = "dipakai" WHERE `mejas`.`id` = NEW.meja_id;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::unprepared('DROP TRIGGER `count_transaksi`');
        \DB::unprepared('DROP TRIGGER `change_status`');
        \DB::unprepared('DROP PROCEDURE IF EXISTS `count_transaksi`');
    }
};
