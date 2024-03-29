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
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code')->unique()->nullable();
            $table->string('asset_brand')->nullable();
            $table->string('date_issued')->nullable();
            $table->mediumText('remarks')->nullable();
            $table->text('history')->nullable();
            $table->enum('status', ['Active', 'With User',  'Pending Confirmation', 'Damaged', 'Missing', 'Returned', 'In Active'])->default('Active');
            $table->string('asset_serial')->nullable();
            $table->string('company')->nullable();

            $table->unsignedBigInteger('arf_form_id')->nullable();
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
        Schema::dropIfExists('printers');
    }
};
