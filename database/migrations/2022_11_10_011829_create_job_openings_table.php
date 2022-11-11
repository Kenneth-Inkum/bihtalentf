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
        Schema::create('job_openings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('job_title_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('industry_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('job_type',['Contract','Full-Time','Part-Time','Temporary']);
            $table->text('job_description');
            $table->text('duty')->nullable();
            $table->foreignId('location_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('required_skill');
            $table->text('activity');
            $table->text('challenge');
            $table->text('experience');
            $table->decimal('salary',10,2);
            $table->dateTime('closing_date');
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
        Schema::dropIfExists('job_openings');
    }
};
