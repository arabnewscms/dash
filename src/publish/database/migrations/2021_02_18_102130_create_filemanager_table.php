<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilemanagerTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('filemanager', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->foreignId('user_id')->nullable()->constrained('users')->references('id')->onDelete('cascade')->onUpdate('cascade');
			$table->string('file');
			$table->string('full_path');
			$table->string('storage_type')->nullable();
			$table->longText('url')->nullable();
			$table->morphs('file');
			$table->string('path')->nullable();
			$table->string('ext')->nullable();
			$table->string('name')->nullable();
			$table->string('size')->nullable();
			$table->bigInteger('size_bytes')->nullable();
			$table->string('mimtype')->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('filemanager');
	}
}
