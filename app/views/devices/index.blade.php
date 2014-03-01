<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Context Switch</title>
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="container">
			<div style="padding: 50px 0 30px; text-style: italic;">Einträge: {{ $devices->count() }}</div>
			@if ($devices->count())
				<table class="table table-condensed table-hover">
					<thead>
						<tr>
							<th>Model</th>
							<th>Brand</th>
							<th>Product</th>
							<th>Manufacturer</th>
							<th>Hardware</th>
							<th>Device</th>
							<th>Board</th>
							<th>CPU ABI</th>
							<th>CPU ABI #2</th>
							<th>CPU Usage</th>
							<th>CPU Freq</th>
							<th>Memory Usage</th>
							<th>Kernel</th>
							<th>Android</th>
							<th>JNI Java→C</th>
							<th>JNI C→Java</th>
							<th>JNI Delta</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						@foreach($devices as $device)
							<tr>
								<td><strong>{{ $device->model }}</strong></td>
								<td>{{ $device->brand }}</td>
								<td>{{ $device->product }}</td>
								<td>{{ $device->manufacturer }}</td>
								<td>{{ $device->hardware }}</td>
								<td>{{ $device->device }}</td>
								<td>{{ $device->board }}</td>
								<td>{{ $device->cpu_abi }}</td>
								<td>{{ $device->cpu_abi_2 }}</td>
								<td>{{ $device->cpu_usage }}</td>
								<td>{{ $device->cpu_freq }}</td>
								<td>{{ $device->memory_usage }}</td>
								<td>{{ $device->kernel }}</td>
								<td>{{ $device->android }}</td>
								<td><strong>{{ $device->jni_from_java_to_c }}</strong></td>
								<td><strong>{{ $device->jni_from_c_to_java }}</strong></td>
								<td><strong>{{ $device->jni_delta }}</strong></td>
								<td>{{ $device->created_at }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
		</div>
	</body>
</html>