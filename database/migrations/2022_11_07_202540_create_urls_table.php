<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urls', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->references("id")->on("users")->nullOnDelete();
            $table->text("url");
            $table->string("code")->unique();
            $table->boolean("is_active")->default(1);
            $table->bigInteger("visits_number")->nullable()->default(0);
            $table->date("valid_till");
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
        Schema::dropIfExists('urls');
    }
}
