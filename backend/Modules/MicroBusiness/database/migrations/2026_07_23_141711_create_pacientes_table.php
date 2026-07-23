<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'microbusiness';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->connection)->create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('cedula', 10)->unique();
            $table->string('nombre', 50)->notNull();
            $table->string('apellido', 50)->notNull();
            $table->date('fecha_nacimiento')->notNull();
            $table->string('direccion', 100)->notNull();
            $table->string('correo', 100)->unique();
            $table->string('telefono', 15)->notNull();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('pacientes');
    }
};