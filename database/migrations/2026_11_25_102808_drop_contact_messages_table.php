<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('contact_messages');
    }

    public function down(): void
    {
        // Intentionally empty: form_submissions replaces this table.
    }
};