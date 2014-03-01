<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDevicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('devices', function(Blueprint $table) {
			$table->increments('id');
			$default = "-";
			$table->string('model', 100)->default($default);
			$table->string('brand', 100)->default($default);
			$table->string('product', 100)->default($default);
			$table->string('manufacturer', 100)->default($default);
			$table->string('hardware', 100)->default($default);
			$table->string('device', 100)->default($default);
			$table->string('board', 100)->default($default);
			$table->string('cpu_abi', 100)->default($default);
			$table->string('cpu_abi_2', 100)->default($default);
			$table->string('cpu_usage', 100)->default($default);
			$table->string('cpu_freq', 100)->default($default);
			$table->string('memory_usage', 100)->default($default);
			$table->string('kernel', 100)->default($default);
			$table->string('android', 100)->default($default);
			$table->string('jni_from_java_to_c', 100)->default($default);
			$table->string('jni_from_c_to_java', 100)->default($default);
			$table->string('jni_delta', 100)->default($default);
			$table->string('acce_latency_sdk', 100)->default($default);
			$table->string('acce_latency_ndk', 100)->default($default);
			$table->string('acce_freq_sdk', 100)->default($default);
			$table->string('acce_freq_ndk', 100)->default($default);
			$table->string('gyro_latency_sdk', 100)->default($default);
			$table->string('gyro_latency_ndk', 100)->default($default);
			$table->string('gyro_freq_sdk', 100)->default($default);
			$table->string('gyro_freq_ndk', 100)->default($default);
			$table->string('magnetometer_latency_sdk', 100)->default($default);
			$table->string('magnetometer_latency_ndk', 100)->default($default);
			$table->string('magnetometer_freq_sdk', 100)->default($default);
			$table->string('magnetometer_freq_ndk', 100)->default($default);
			$table->string('barometer_latency_sdk', 100)->default($default);
			$table->string('barometer_latency_ndk', 100)->default($default);
			$table->string('barometer_freq_sdk', 100)->default($default);
			$table->string('barometer_freq_ndk', 100)->default($default);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('devices');
	}

}
