<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_emails_eml', function (Blueprint $table) {
            $table->increments('eml_id');
            $table->foreignId('id_contacto')->constrained('tbl_contactos_cts')->onDelete('cascade');
            $table->string('eml_email', 255);
        }, 'InnoDB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_emails_eml');

    }
};
