<?php

use App\Models\Degree;
use App\Models\VeteranStatus;
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
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
//            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('type', ['حقیقی', 'حقوقی'])->nullable();
            $table->string('national_code')->unique()->nullable();
            $table->string('full_name')->nullable();
            $table->enum('life_status', ['در قید حیات', 'فوت شده']);
            $table->string('father_name')->nullable();
            $table->string('birth_certificate_number')->unique()->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_location')->nullable();
            $table->foreignIdFor(Degree::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('major')->nullable();
            $table->enum('marital_status', ['مجرد', 'متاهل'])->nullable();
            $table->integer('child_count')->nullable();
            $table->foreignIdFor(VeteranStatus::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('landline_number')->nullable();
            $table->string('mobile')->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veteran_statuses');
    }
};
