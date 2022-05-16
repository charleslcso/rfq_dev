<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfqs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('telephone');
            $table->string('email', 100);
            $table->string('company_name', 100);
            $table->string('company_address', 200);
            $table->string('project_name', 100);
            $table->boolean('is_tvp');
            $table->text('project_requirements');
            $table->string('expected_budget', 100);
            $table->text('notes');
            $table->integer('number_of_rfqs');
            $table->string('payment_received');
            $table->string('ip');
            $table->text('stripe_data');
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
        Schema::dropIfExists('rfqs');
    }
}
