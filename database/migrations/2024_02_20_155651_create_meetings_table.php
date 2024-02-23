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

    public function up(): void

    {

        Schema::create('meetings', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->boolean('deleted')->default(false);

            $table->timestamp('date_start');

            $table->timestamp('date_end');

            $table->boolean('is_all_day')->default(true);
            
            $table->text('description')->nullable();

            $table->timestamps();
            
            $table->string('cretaed_by_id')->nullable();
            
            $table->string('updated_by_id')->nullable();

            $table->string('assigned_user_id')->nullable();
        });
    }



    /**

     * Reverse the migrations.

     *

     * @return void

     */

    public function down(): void

    {

        Schema::dropIfExists('meetings');
    }
};
