@extends('buyer-side.master.index')
@section('content')
<script src='https://api.mapbox.com/mapbox-gl-js/v0.49.0/mapbox-gl.js'></script>

<center>
	<br>

	
	<center>
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3858.795301845491!2d121.03681831439833!3d14.724161989723878!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b0ff2c71d3d5%3A0xfa7ee1d7272c67d2!2sMchotel!5e0!3m2!1sen!2sph!4v1536908171357" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

	</center>
	 <div id="as-root"><h2>Track with delivery number</h2>
	<br>
	<br>
	<br>
	<br>
	 	</div><script>(function(e,t,n){var r,i=e.getElementsByTagName(t)[0];if(e.getElementById(n))return;
r=e.createElement(t);r.id=n;r.src="//button.aftership.com/all.js";i.parentNode.insertBefore(r,i)})(document,"script","aftership-jssdk")</script>

<div class="as-track-button" data-size="large" data-domain="buildcommerce.aftership.com"></div>
</center>

@endsection
@push('script')

@endpush