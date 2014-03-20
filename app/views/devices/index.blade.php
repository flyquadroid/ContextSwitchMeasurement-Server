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
		<div style="width: 4500px; padding: 50px;">
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
							<th>Acce Latency SDK</th>
							<th>Acce Latency NDK</th>
							<th>Acce Freq SDK</th>
							<th>Acce Freq NDK</th>
							<th>Gyro Latency SDK</th>
							<th>Gyro Latency NDK</th>
							<th>Gyro Freq SDK</th>
							<th>Gyro Freq NDK</th>
							<th>Magnetometer Latency SDK</th>
							<th>Magnetometer Latency NDK</th>
							<th>Magnetometer Freq SDK</th>
							<th>Magnetometer Freq NDK</th>
							<th>Barometer Latency SDK</th>
							<th>Barometer Latency NDK</th>
							<th>Barometer Freq SDK</th>
							<th>Barometer Freq NDK</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						@foreach($devices as $device)
							<tr>
								<td>{{ $device->model }}</td>
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
								<td>{{ $device->jni_from_java_to_c }}</td>
								<td>{{ $device->jni_from_c_to_java }}</td>
								<td>{{ $device->jni_delta }}</td>
								<td>{{ $device->acce_latency_sdk }}</td>
								<td>{{ $device->acce_latency_ndk }}</td>
								<td>{{ $device->acce_freq_sdk }}</td>
								<td>{{ $device->acce_freq_ndk }}</td>
								<td>{{ $device->gyro_latency_sdk }}</td>
								<td>{{ $device->gyro_latency_ndk }}</td>
								<td>{{ $device->gyro_freq_sdk }}</td>
								<td>{{ $device->gyro_freq_ndk }}</td>
								<td>{{ $device->magnetometer_latency_sdk }}</td>
								<td>{{ $device->magnetometer_latency_ndk }}</td>
								<td>{{ $device->magnetometer_freq_sdk }}</td>
								<td>{{ $device->magnetometer_freq_ndk }}</td>
								<td>{{ $device->barometer_latency_sdk }}</td>
								<td>{{ $device->barometer_latency_ndk }}</td>
								<td>{{ $device->barometer_freq_sdk }}</td>
								<td>{{ $device->barometer_freq_ndk }}</td>
								<td>{{ $device->created_at }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div>

					{{-- JNI --}}
					<h4>JNI</h4>
					<small>
						<?php
							$coordinates = "";
							$ymin = INF;
							$ymax = INF;
							$average = 0;
						?>
						@foreach ($devices as $index => $device)
							<?php
								$n = $device->jni_from_java_to_c;
								$coordinates .= " (".($index+1).",".$n.")";
								if(is_infinite($ymin)){
									$ymin = $n;
								} else {
									if($n<$ymin){
										$ymin = $n;
									}
								}
								if(is_infinite($ymax)){
									$ymax = $n;
								} else {
									if($n>$ymax){
										$ymax = $n;
									}
								}
								$average+=$n;
							?>
						@endforeach
						<pre>\begin{figure}[ht]
\begin{tikzpicture}
\begin{axis}[
axis lines=middle,
scale only axis,
width=2.8in,
height=2in,
xtick=data,
xmin=1, xmax={{ $devices->count() }},
ymin={{ ($ymin-10) }}, ymax={{ ($ymax+10) }},
nodes near coords,
axis on top]
\addplot[
  ybar,
  bar width=0.2in,
  bar shift=0in,
  fill=blue,
  draw=black]
  plot coordinates{
    {{ $coordinates }}
  };
\end{axis}
\end{tikzpicture}
\caption{caption}
\label{fig:label}
\end{figure}</pre>
						<div>Average: {{ $average/$devices->count() }}</div>
						<hr>
						<?php
							$average_java_to_c = 0;
							$average_c_to_java = 0;
							$average_jni_delta = 0;
						?>
						@foreach ($devices as $index => $device)
							<?php
								$average_java_to_c += $device->jni_from_java_to_c;
								$average_c_to_java += $device->jni_from_c_to_java;
								$average_jni_delta += ($device->jni_from_c_to_java-$device->jni_from_java_to_c);
							?>
						@endforeach
<pre>
\begin{filecontents}{jni.dat}
@foreach ($devices as $index => $device)
{{ ($index+1) }},{{$device->jni_from_java_to_c}},{{$device->jni_from_c_to_java}}

@endforeach
\end{filecontents}
\begin{figure}[ht]
\begin{tikzpicture}
\begin{axis}[xlabel={Test},ylabel={Nanoseconds (NS)}]
\addplot table[x index=0,y index=1,col sep=comma] {jni.dat};
\addlegendentry{Java to C}
\addplot table[x index=0,y index=2,col sep=comma] {jni.dat};
\addlegendentry{C to Java}
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ (int)($average_java_to_c/$devices->count()) }} };
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ (int)($average_c_to_java/$devices->count()) }} };
\end{axis}
\end{tikzpicture}
\caption{TITLE}
\end{figure}
</pre>
<pre>
\begin{filecontents}{jni_delta.dat}
@foreach ($devices as $index => $device)
{{ ($index+1) }},{{($device->jni_from_c_to_java-$device->jni_from_java_to_c)}}

@endforeach
\end{filecontents}
\begin{figure}[ht]
\begin{tikzpicture}
\begin{axis}[xlabel={Test},ylabel={Nanoseconds (NS)}]
\addplot table[x index=0,y index=1,col sep=comma] {jni_delta.dat};
\addlegendentry{Delta between Java and C}
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ (int)($average_jni_delta/$devices->count()) }} };
\end{axis}
\end{tikzpicture}
\caption{TITLE}
\end{figure}
</pre>
					</small>
				</div>

				{{-- Accelerometer Latency --}}
				<div>
					<?php
						$title = "Accelerometer Latency";
						$average_sdk = 0;
						$average_ndk = 0;
					?>
					@foreach ($devices as $index => $device)
						<?php
							$average_sdk += $device->acce_latency_sdk;
							$average_ndk += $device->acce_latency_ndk;
						?>
					@endforeach
					<?php
						$average_sdk = (int)($average_sdk/$devices->count());
						$average_ndk = (int)($average_ndk/$devices->count());
					?>
					<h4>{{ $title }}</h4>
					<small>
<pre>
\begin{filecontents}{acce_lat.dat}
@foreach ($devices as $index => $device)
{{ ($index+1) }},{{$device->acce_latency_sdk}},{{$device->acce_latency_ndk}}

@endforeach
\end{filecontents}
\begin{figure}[ht]
\begin{tikzpicture}
\begin{axis}[xlabel={Test},ylabel={Milliseconds (MS)}]
\addplot table[x index=0,y index=1,col sep=comma] {acce_lat.dat};
\addlegendentry{ {{ $title }} SDK }
\addplot table[x index=0,y index=2,col sep=comma] {acce_lat.dat};
\addlegendentry{ {{ $title }} NDK }
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ $average_sdk }} };
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ $average_ndk }} };
\end{axis}
\end{tikzpicture}
\caption{ {{ $title }} }
\end{figure}
</pre>
					</small>
				</div>

				{{-- Accelerometer Frequency --}}
				<div>
					<?php
						$title = "Accelerometer Frequency";
						$average_sdk = 0;
						$average_ndk = 0;
					?>
					@foreach ($devices as $index => $device)
						<?php
							$average_sdk += $device->acce_freq_sdk;
							$average_ndk += $device->acce_freq_ndk;
						?>
					@endforeach
					<?php
						$average_sdk = (int)($average_sdk/$devices->count());
						$average_ndk = (int)($average_ndk/$devices->count());
					?>
					<h4>{{ $title }}</h4>
					<small>
<pre>
\begin{filecontents}{acce_freq.dat}
@foreach ($devices as $index => $device)
{{ ($index+1) }},{{$device->acce_freq_sdk}},{{$device->acce_freq_ndk}}

@endforeach
\end{filecontents}
\begin{figure}[ht]
\begin{tikzpicture}
\begin{axis}[xlabel={Test},ylabel={Milliseconds (MS)}]
\addplot table[x index=0,y index=1,col sep=comma] {acce_freq.dat};
\addlegendentry{ {{ $title }} SDK }
\addplot table[x index=0,y index=2,col sep=comma] {acce_freq.dat};
\addlegendentry{ {{ $title }} NDK }
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ $average_sdk }} };
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ $average_ndk }} };
\end{axis}
\end{tikzpicture}
\caption{ {{ $title }} }
\end{figure}
</pre>
					</small>
				</div>

				{{-- Gyroscope Latency --}}
				<div>
					<?php
						$title = "Gyroscope Latency";
						$average_sdk = 0;
						$average_ndk = 0;
					?>
					@foreach ($devices as $index => $device)
						<?php
							$average_sdk += $device->gyro_latency_sdk;
							$average_ndk += $device->gyro_latency_ndk;
						?>
					@endforeach
					<?php
						$average_sdk = (int)($average_sdk/$devices->count());
						$average_ndk = (int)($average_ndk/$devices->count());
					?>
					<h4>{{ $title }}</h4>
					<small>
<pre>
\begin{filecontents}{gyro_lat.dat}
@foreach ($devices as $index => $device)
{{ ($index+1) }},{{$device->gyro_latency_sdk}},{{$device->gyro_latency_ndk}}

@endforeach
\end{filecontents}
\begin{figure}[ht]
\begin{tikzpicture}
\begin{axis}[xlabel={Test},ylabel={Milliseconds (MS)}]
\addplot table[x index=0,y index=1,col sep=comma] {gyro_lat.dat};
\addlegendentry{ {{ $title }} SDK }
\addplot table[x index=0,y index=2,col sep=comma] {gyro_lat.dat};
\addlegendentry{ {{ $title }} NDK }
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ $average_sdk }} };
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ $average_ndk }} };
\end{axis}
\end{tikzpicture}
\caption{ {{ $title }} }
\end{figure}
</pre>
					</small>
				</div>

				{{-- Gyroscope Frequency --}}
				<div>
					<?php
						$title = "Gyroscope Frequency";
						$average_sdk = 0;
						$average_ndk = 0;
					?>
					@foreach ($devices as $index => $device)
						<?php
							$average_sdk += $device->gyro_freq_sdk;
							$average_ndk += $device->gyro_freq_ndk;
						?>
					@endforeach
					<?php
						$average_sdk = (int)($average_sdk/$devices->count());
						$average_ndk = (int)($average_ndk/$devices->count());
					?>
					<h4>{{ $title }}</h4>
					<small>
<pre>
\begin{filecontents}{gyro_freq.dat}
@foreach ($devices as $index => $device)
{{ ($index+1) }},{{$device->gyro_freq_sdk}},{{$device->gyro_freq_ndk}}

@endforeach
\end{filecontents}
\begin{figure}[ht]
\begin{tikzpicture}
\begin{axis}[xlabel={Test},ylabel={Milliseconds (MS)}]
\addplot table[x index=0,y index=1,col sep=comma] {gyro_freq.dat};
\addlegendentry{ {{ $title }} SDK }
\addplot table[x index=0,y index=2,col sep=comma] {gyro_freq.dat};
\addlegendentry{ {{ $title }} NDK }
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ $average_sdk }} };
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ $average_ndk }} };
\end{axis}
\end{tikzpicture}
\caption{ {{ $title }} }
\end{figure}
</pre>
					</small>
				</div>

				{{-- Magnetometer Latency --}}
				<div>
					<?php
						$title = "Magnetometer Latency";
						$average_sdk = 0;
						$average_ndk = 0;
					?>
					@foreach ($devices as $index => $device)
						<?php
							$average_sdk += $device->magnetometer_latency_sdk;
							$average_ndk += $device->magnetometer_latency_ndk;
						?>
					@endforeach
					<?php
						$average_sdk = (int)($average_sdk/$devices->count());
						$average_ndk = (int)($average_ndk/$devices->count());
					?>
					<h4>{{ $title }}</h4>
					<small>
<pre>
\begin{filecontents}{magnetometer_lat.dat}
@foreach ($devices as $index => $device)
{{ ($index+1) }},{{$device->magnetometer_latency_sdk}},{{$device->magnetometer_latency_ndk}}

@endforeach
\end{filecontents}
\begin{figure}[ht]
\begin{tikzpicture}
\begin{axis}[xlabel={Test},ylabel={Milliseconds (MS)}]
\addplot table[x index=0,y index=1,col sep=comma] {magnetometer_lat.dat};
\addlegendentry{ {{ $title }} SDK }
\addplot table[x index=0,y index=2,col sep=comma] {magnetometer_lat.dat};
\addlegendentry{ {{ $title }} NDK }
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ $average_sdk }} };
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ $average_ndk }} };
\end{axis}
\end{tikzpicture}
\caption{ {{ $title }} }
\end{figure}
</pre>
					</small>
				</div>

				{{-- Magnetometer Frequency --}}
				<div>
					<?php
						$title = "Magnetometer Frequency";
						$average_sdk = 0;
						$average_ndk = 0;
					?>
					@foreach ($devices as $index => $device)
						<?php
							$average_sdk += $device->magnetometer_freq_sdk;
							$average_ndk += $device->magnetometer_freq_ndk;
						?>
					@endforeach
					<?php
						$average_sdk = (int)($average_sdk/$devices->count());
						$average_ndk = (int)($average_ndk/$devices->count());
					?>
					<h4>{{ $title }}</h4>
					<small>
<pre>
\begin{filecontents}{magnetometer_freq.dat}
@foreach ($devices as $index => $device)
{{ ($index+1) }},{{$device->magnetometer_freq_sdk}},{{$device->magnetometer_freq_ndk}}

@endforeach
\end{filecontents}
\begin{figure}[ht]
\begin{tikzpicture}
\begin{axis}[xlabel={Test},ylabel={Milliseconds (MS)}]
\addplot table[x index=0,y index=1,col sep=comma] {magnetometer_freq.dat};
\addlegendentry{ {{ $title }} SDK }
\addplot table[x index=0,y index=2,col sep=comma] {magnetometer_freq.dat};
\addlegendentry{ {{ $title }} NDK }
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ $average_sdk }} };
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ $average_ndk }} };
\end{axis}
\end{tikzpicture}
\caption{ {{ $title }} }
\end{figure}
</pre>
					</small>
				</div>

				{{-- Barometer Latency --}}
				<div>
					<?php
						$title = "Barometer Latency";
						$average_sdk = 0;
						$average_ndk = 0;
					?>
					@foreach ($devices as $index => $device)
						<?php
							$average_sdk += $device->barometer_latency_sdk;
							$average_ndk += $device->barometer_latency_ndk;
						?>
					@endforeach
					<?php
						$average_sdk = (int)($average_sdk/$devices->count());
						$average_ndk = (int)($average_ndk/$devices->count());
					?>
					<h4>{{ $title }}</h4>
					<small>
<pre>
\begin{filecontents}{barometer_lat.dat}
@foreach ($devices as $index => $device)
{{ ($index+1) }},{{$device->barometer_latency_sdk}},{{$device->barometer_latency_ndk}}

@endforeach
\end{filecontents}
\begin{figure}[ht]
\begin{tikzpicture}
\begin{axis}[xlabel={Test},ylabel={Milliseconds (MS)}]
\addplot table[x index=0,y index=1,col sep=comma] {barometer_lat.dat};
\addlegendentry{ {{ $title }} SDK }
\addplot table[x index=0,y index=2,col sep=comma] {barometer_lat.dat};
\addlegendentry{ {{ $title }} NDK }
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ $average_sdk }} };
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ $average_ndk }} };
\end{axis}
\end{tikzpicture}
\caption{ {{ $title }} }
\end{figure}
</pre>
					</small>
				</div>

				{{-- Barometer Frequency --}}
				<div>
					<?php
						$title = "Barometer Frequency";
						$average_sdk = 0;
						$average_ndk = 0;
					?>
					@foreach ($devices as $index => $device)
						<?php
							$average_sdk += $device->barometer_freq_sdk;
							$average_ndk += $device->barometer_freq_ndk;
						?>
					@endforeach
					<?php
						$average_sdk = (int)($average_sdk/$devices->count());
						$average_ndk = (int)($average_ndk/$devices->count());
					?>
					<h4>{{ $title }}</h4>
					<small>
<pre>
\begin{filecontents}{barometer_freq.dat}
@foreach ($devices as $index => $device)
{{ ($index+1) }},{{$device->barometer_freq_sdk}},{{$device->barometer_freq_ndk}}

@endforeach
\end{filecontents}
\begin{figure}[ht]
\begin{tikzpicture}
\begin{axis}[xlabel={Test},ylabel={Milliseconds (MS)}]
\addplot table[x index=0,y index=1,col sep=comma] {barometer_freq.dat};
\addlegendentry{ {{ $title }} SDK }
\addplot table[x index=0,y index=2,col sep=comma] {barometer_freq.dat};
\addlegendentry{ {{ $title }} NDK }
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ $average_sdk }} };
\addplot [mark=none, thin, domain=1:{{ $devices->count() }}, samples=2] { {{ $average_ndk }} };
\end{axis}
\end{tikzpicture}
\caption{ {{ $title }} }
\end{figure}
</pre>
					</small>
				</div>

			@endif
		</div>
	</body>
</html>