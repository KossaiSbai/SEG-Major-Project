<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePatientsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->string('forename')->nullable(false);
            $table->string('surname')->nullable(false);
            $table->integer('patient_id')->nullable(false);//patient_id = NHS number
            $table->primary('patient_id');
            $table->integer('internal_id')->unique()->nullable(false);
            $table->date('date_of_birth')->nullable(false);
            $table->string('sex')->nullable(false);
            $table->string('test_frequency')->default('two_weeks');
            $table->date('test_date')->nullable(true);
            $table->string('is_complex')->default('no');
            $table->string('reviewed')->default('no');
            $table->string('received')->default('no');
            $table->string('preferred_contact')->default('email');
            $table->text('diagnosis')->nullable(true);
            $table->string('transplant')->nullable(true);
            $table->string('contact')->nullable(true);
            $table->string('email')->nullable(true);
            $table->text('comments')->nullable(true);
            $table->string('tAC')->nullable(true);
            $table->string('hospital')->nullable(false);
            $table->foreign('hospital')->references('hospital_id')->on('hospitals')->onUpdate('cascade');
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
        Schema::dropIfExists('patients');
    }
}