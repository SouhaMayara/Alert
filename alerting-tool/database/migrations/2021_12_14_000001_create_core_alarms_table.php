<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreAlarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_alarms', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            //$table->timestamp('create_timestamp')->default(DB::raw('CURRENT_TIMESTAMP(0)'));
            $table->timestamp('create_timestamp')->useCurrent();
            $table->boolean('confirmed')->default(0);
            $table->timestamp('confirm_timestamp')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_alarms');
    }
}
