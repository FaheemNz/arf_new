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
        Schema::create('arf_forms', function (Blueprint $table) {
            $table->id();
            
            $table->string('name');
            $table->string('email');
            $table->text('contact_details')->nullable();
            $table->string('emp_id', 255)->nullable();
            $table->enum('status', ['Waiting Confirmation', 'Acknowledged', 'In Active'])->default('Waiting Confirmation');
            
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('office_location_id');
            
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
        Schema::dropIfExists('arf_forms');
    }
};
