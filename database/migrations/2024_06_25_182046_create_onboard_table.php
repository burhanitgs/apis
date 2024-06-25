<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('onboard', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('birth_sex');
			$table->string('employment_status');
			$table->string('occupation');
			$table->string('education_level');
			$table->string('total_children');
			$table->string('pregnant');
			$table->string('gestation');
			$table->string('expected_babies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onboard');
    }
};
