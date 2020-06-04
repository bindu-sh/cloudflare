<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloudflareRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dnsRecords', function (Blueprint $table) {
            $table->id();
            $table->text('zone_id');
            $table->text('identifier');
            $table->string('type');
            $table->string('name');
            $table->text('content');
            $table->string('ttl');
            $table->string('proxy_status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dnsRecords');
    }
}
