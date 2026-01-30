<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branding_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('logo_path')->nullable();
            $table->string('primary_color')->default('#2563eb');
            $table->string('secondary_color')->default('#0f172a');
            $table->string('theme_mode')->default('light');
            $table->string('pdf_theme')->default('classic');
            $table->boolean('show_tax')->default(true);
            $table->boolean('show_discount')->default(true);
            $table->boolean('show_sku')->default(true);
            $table->boolean('show_notes')->default(true);
            $table->boolean('show_terms')->default(true);
            $table->string('font_family')->default('Inter');
            $table->text('footer_text')->nullable();
            $table->string('email_invoice_subject');
            $table->text('email_invoice_body');
            $table->string('email_reminder_upcoming_subject');
            $table->text('email_reminder_upcoming_body');
            $table->string('email_reminder_overdue_subject');
            $table->text('email_reminder_overdue_body');
            $table->string('number_prefix')->default('INV-');
            $table->unsignedInteger('number_next')->default(1);
            $table->unsignedTinyInteger('number_padding')->default(6);
            $table->boolean('number_yearly_reset')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branding_settings');
    }
};
