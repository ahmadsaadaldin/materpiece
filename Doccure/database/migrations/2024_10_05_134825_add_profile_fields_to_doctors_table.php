<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('clinic_name')->nullable();
            $table->string('clinic_address')->nullable();
            $table->text('clinic_images')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('biography')->nullable();
            $table->string('services')->nullable();
            $table->string('specialization')->nullable();
            $table->json('education')->nullable();
            $table->json('experience')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn([
                'gender', 'date_of_birth', 'clinic_name', 'clinic_address',
                'clinic_images', 'address_line_1', 'address_line_2', 'city', 'state', 'country',
                'postal_code', 'biography', 'services', 'specialization', 'education', 'experience'
            ]);
        });
    }
    
};
