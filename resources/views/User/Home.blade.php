@extends('__partials.commonMaster')

@section('title', 'Home Page')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{ asset('new_css/style.css') }}">
@endsection

@section('content')

    @include('__partials.nav')

    <div class="body">
        <div class="weather-container">
            <h5>Matalom, Leyte, Philipines</h5>
            <h6>{{ date('l') }}, {{ date('F j, Y') }}, <span id="clock" style="position: absolute;top:2.76em;left:19em"></span></h6>
            
            <img id="location" src="{{asset('assets/img/location.png')}}" alt="">
            <p>Currently</p>
            <h1>{{ $weatherData['main']['temp'] }}°C</h1>
            <span >{{ $weatherData['weather'][0]['description'] }}</span>
            <span class="mt-4">Humidity : {{ $weatherData['main']['humidity'] }}</span>
            @if ($weatherData['main']['temp'] <= 33 && $weatherData['main']['temp'] >= 26)
                <img id="weather-icon"src="{{asset('assets/img/cloudy.png')}}" alt="">
            @elseif ($weatherData['main']['temp'] < 26)
                <img id="weather-icon"src="{{asset('assets/img/rainy.png')}}" alt="">
            @elseif ($weatherData['main']['temp'] > 36)
                <img id="weather-icon"src="{{asset('assets/img/sun.png')}}" alt="">
            @endif
        </div>
        <div class="intro"> 
            <div style="margin-right:10em;margin-top:8em">
                <h1>Exhausted? </h1>
                <h2>Come and Take a Break in a Stress World! </h2>
            </div>
            
            <img src="{{asset('assets/img/hotel.jpg')}}" alt="">
        </div>
        <hr>
        <h1>Our Rooms</h1>
        <div class="list-room">
            <div class="a-list">
                <img class="list" src="{{asset('assets/img/room1.jpg')}}" alt="">
            </div>
            <div class="b-list">
                <img class="list" src="{{asset('assets/img/room2.jpg')}}" alt="">
            </div>
            <div class="c-list">
                <img class="list" src="{{asset('assets/img/room3.jpg')}}" alt="">
            </div>
        </div>
        <hr>
        <div class="section3">
            <div class="contact">
                <div>
                    <h5>Call Us</h5>
                    <h6>+63 909 4211 995</h6>
                </div>
                <div>
                    <h5>Email Us</h5>
                    <h6>pagal.alien.golo@gmail.com</h6>
                </div>
                
            </div>
            <hr class="vertical-hr">
            <div class="address">
                <h5>Address</h5>
                <h6>Brgy.Caridad Sur, Matalom, Leyte, Philipines</h6>
            </div>
            <hr class="vertical-hr">
            <div class="time">
                <h5>Arrival Time</h5>
                <h6>Checks in 3pm -->  Check-out 12pm</h6>
            </div>
        </div>
        
        <div class="section4">
        </div>


        
    </div>
    <script>
        function updateClock() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();

            // Convert hours to 12-hour format
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // Handle midnight (0 hours)

            // Add leading zeros to single-digit minutes and seconds
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            var timeString = hours + ':' + minutes + ':' + seconds + ' ' + ampm;

            document.getElementById('clock').textContent = timeString;

            // Update every second
            setTimeout(updateClock, 1000);
        }

        // Call updateClock function when page loads
        window.onload = updateClock;
    </script>
@endsection