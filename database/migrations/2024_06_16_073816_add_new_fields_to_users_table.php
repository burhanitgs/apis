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
        Schema::table('users', function (Blueprint $table) {
            //
			$table->string('first_name', 15)->nullable()->after('name');
			$table->string('middle_name', 15)->nullable()->after('first_name');
			$table->string('last_name', 15)->nullable()->after('middle_name');
			$table->string('phone_number')->nullable()->after('email');
			$table->string('address')->nullable()->after('phone_number');
			$table->date('date_of_birth')->nullable()->after('phone_number');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
			$table->string('first_name', 15)->nullable()->after('name');
			$table->string('middle_name', 15)->nullable()->after('first_name');
			$table->string('last_name', 15)->nullable()->after('middle_name');
			$table->string('phone_number')->nullable()->after('email');
			$table->string('address')->nullable()->after('phone_number');
			$table->date('date_of_birth')->nullable()->after('phone_number');
			
        });
    }
};
