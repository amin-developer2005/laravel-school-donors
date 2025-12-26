<?php

use App\Models\Donor;
use App\Models\FundingSource;
use App\Models\ProjectUsageType;
use App\Models\Region;
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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('status', ['در دست اجرا', 'کامل شده', 'کنسل شده']);
            $table->unsignedBigInteger('space_code');
            $table->enum('urban_rural', ['شهر', 'روستا']);
            $table->string('city')->nullable();
            $table->string('village')->nullable();
            $table->foreignIdFor(Region::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(ProjectUsageType::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->smallInteger('start_year')->unsigned();
            $table->smallInteger('end_year')->unsigned();
            $table->foreignIdFor(FundingSource::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('builder_donor_id')->constrained('donors')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('land_donor_id')->constrained('donors')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->bigInteger('cost')->nullable();
            $table->mediumInteger('main_building_area')->nullable();
            $table->mediumInteger('bathroom_area')->nullable();
            $table->mediumInteger('janitor_area')->nullable();
            $table->mediumInteger('guard_area')->nullable();
            $table->mediumInteger('wall_area')->nullable();
            $table->mediumInteger('land_spacing_area')->nullable();
            $table->mediumInteger('gym_area')->nullable();
            $table->mediumInteger('prayer_room_area')->nullable();
            $table->mediumInteger('total_under_constructions')->nullable();
            $table->mediumInteger('land_area')->nullable();
            $table->mediumInteger('classrooms_count')->nullable();
            $table->string('contractor')->nullable();
            $table->string('supervisor')->nullable();
            $table->text('address')->nullable();
            $table->string('agreement_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
