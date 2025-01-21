<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users', function (Blueprint $table) {
				$table->id();
				$table->string('name');
				$table->string('email')->unique();
				$table->string('mobile')->nullable();
                $table->string('photo')->nullable();
				$table->enum('gender', ['male', 'female'])->nullable();
				$table->timestamp('email_verified_at')->nullable();
				$table->string('password')->default('no_password_for_user')
					->nullable();
				$table->enum('account_type', ['user', 'admin'])->default('user');
				$table->foreignId('admin_group_id')->nullable()->constrained('admin_groups')->references('id')->onDelete('cascade')->onUpdate('cascade');
				$table->rememberToken();
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
		Schema::dropIfExists('users');
	}
}
