<?php namespace AppLogger\Logger\Updates;

use October\Rain\Database\Updates\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    public function up()
    {
        Schema::create('applogger_logger_logs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('arrival_date');
            $table->string('user_name');
            $table->integer('delay');
            $table->string('log_type')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applogger_logger_logs');
    }
}
