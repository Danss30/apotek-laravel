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
        Schema::create('faktur', function (Blueprint $table) {
            $table->id();
            $table->string('no_faktur')->unique();
            $table->date('tgl_faktur');
            $table->date('due_date');
            $table->string('metode_pembayaran');
            $table->decimal('ppn', 10, 2)->default(0);
            $table->decimal('dp', 10, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_customer');
            $table->unsignedBigInteger('id_perusahaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faktur');
    }
};
