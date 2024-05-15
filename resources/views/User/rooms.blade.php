@extends('__partials.commonMaster')

@section('title', 'Rooms')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{ asset('new_css/style.css') }}">
<script src="https://js.stripe.com/v3/"></script>
@endsection


@section('content')
    @include('__partials.nav')
    <div class="body">
        @if (session('paid')=== 'failed')
       
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Date is not Available!!',
                    showConfirmButton: true,
                    confirmButtonText: 'Okay'
                });
            </script>

        @endif

        {{-- Book Now Modal --}}
        <div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg"role="document">
            <div class="modal-content"  >
                <form method="POST" action="{{route('session')}}">
                <div class="modal-header">
                @if (session('username')  && auth()->user() && auth()->user()->hasVerifiedEmail())
                    <h5 class="modal-title" id="exampleModalLongTitle">Book Now</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLongTitle">Login First</h5>
                @endif
                </div>
                <div class="modal-body">
                        <input type="text" id="notice" name="notice" hidden>
                        @if (session('username')  && auth()->user() && auth()->user()->hasVerifiedEmail())
                            <div class="main">
                                <div>
                                    <img id="r_img" name="r_img" style="height: 16em;width:auto" alt="">
                                    <input type="text" hidden id="idholder" name="idholder">
                                    
                                </div>
    
                                <div class="pl-4 w-100">
                                    <h3 class="text-primary mb-1" id="room_n" ></h3>
                                    <input type="text" hidden id="r_name" name="room_n">
                                    <h6 class="form-label text-secondary mb-4" style="font-size:1em " id="room_p"></h6>
                                    <labal class="form-label">Check In</labal>
                                    <input id="start_date" type="date" name="start_date" class="mb-3 form-control date" required>
                                    <input type="number" id="real_price" hidden>
                                    <labal  class="form-label">Check Out</labal>
                                    <input id="end_date" type="date" name="end_date" class="form-control date" required>
    
                                    <h6 class="mt-4 text-secondary"><span></span>Total Day(s) : <span  id="days"></span></h6>
                                    <h6 class="mt-2 text-secondary mb-3"><span></span>Total Amount to be paid : <span  id="total_p">0</span></h6>
                                    <input type="number" name="real_total" id="real_total" hidden>
                                </div>
                                
                            </div>
                            <div class="row notavailable">
                                <label for="" class="form-label text-danger">Not Available date :</label>
                                <div class="notavialablelist">
                                    
                                </div>
                            </div>
                        @else
                            <div class="login-container p-4">
                                <div class="wrap w-60 shadow rounded  m-auto" style="padding: 3em 1.5em 1.5em 1.5em">
                                    <form id="login-form" class="mb-3" action="{{url('/')}}" method="GET">
                                        <div class="mb-3">
                                          <label for="email" class="form-label">Email or Username <span style="color:red"> *</span></label>
                                          <input type="text" class="form-control inputs" id="email" name="email" placeholder="Enter your email or username" autofocus>
                                        </div>
                                        <div class="mb-3 form-password-toggle">
                                          <div class="d-flex justify-content-between">
                                            <label class="form-label" for="password">Password<span style="color:red"> *</span></label>
                                            <a href="{{url('forgot-password')}}">
                                              <small>Forgot Password?</small>
                                            </a>
                                          </div>
                                          <div class="input-group input-group-merge">
                                            <input type="password" id="password" class="form-control inputs" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                          </div>
                                        </div>
                                        <div class="mb-3">
                                          <div class="form-check">
                                            {{-- <input class="form-check-input" type="checkbox" id="remember-me"> --}}
                                            <label class="form-check-label" for="remember-me">
                                              {{-- Remember Me --}}
                                            </label>
                                          </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                          <button class="btn btn-primary d-grid w-100" id="login-btn"type="submit">Sign in</button>
                                          <h6 style="text-align:center;margin:.5em 0">or</h6>
                                        </div>
                                        {{-- Login with Google --}}
                                        <div id="g_id_onload"
                                              data-client_id="{{env('GOOGLE_CLIENT_ID')}}"
                                              data-callback="onSignIn"></div>
                                        <div class="g_id_signin form-control" data-type="standard"></div>
                                        <p id="max-attempt" style="color:red"></p>
                                      </form>
                                </div>
                            </div>
                        @endif
                    
                </div>
                <div class="modal-footer">
                    @if (session('username')  && auth()->user() && auth()->user()->hasVerifiedEmail())
                    
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button hidden type="submit" id="hidebtn">hide</button>
                        <button type="button" id="closebook" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="book_now" class="btn btn-success">Book Now</button>
                    
                        
                    @else
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Okay</button>
                    @endif
                
                </div>
            </form>
            </div>
            </div>
        </div>


    <h1 class="headings">OUR ROOMS</h1>
        <div class="divider">
            <div class="left">
                <h5>FILTERS</h5>
                <i class='fa fa-refresh' id="refresh"></i>
                {{-- CHECK AVAILABILITY --}}
                <div class="filter-wrapper bg-white" style="box-shadow:.2em .2em 1em rgba(110,110,110,.3)">
                    <h6>CHECK AVAILABILITY</h6>
                    <span>Check-in</span>
                    <input type="date" id="fromdate" class="form-control" value="{{ session('in')}}">
                    <span>Check-out</span>
                    <input type="date" id="enddate" class="form-control"value="{{session('out')}}" >
                </div>
                <div class="filter-wrapper bg-white" style="box-shadow:.2em .2em 1em rgba(110,110,110,.3)">
                    <h6>Room Type</h6>
                    <select name="" id="Scategory" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{$category->Name}}"> {{$category->Name}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="filter-wrapper bg-white" style="box-shadow:.2em .2em 1em rgba(110,110,110,.3)">
                    <h6>Guest</h6>
                    <div class="roww" style="justify-content:space-around">
                        <span>Adult</span>
                        <span>Kids</span>
                    </div>
                    <div class="roww">
                        <input type="number" id="Sadult" class="form-control">
                        <input type="number" id="Schildren" class="form-control">
                    </div>
                </div>
                {{-- Filter Aminities --}}
                <div class="filter-wrapper bg-white" style="box-shadow:.2em .2em 1em rgba(110,110,110,.3)">
                    <h6>Aminities</h6>
                    @foreach ($aminities as $aminity)
                    <div class="roww">
                        <input type="checkbox" class="Saminities select" value="{{ $aminity->name }}">
                        <span> {{$aminity->name}}</span>
                    </div>
                    @endforeach
                    
                </div>

                


               
            </div>
            <div class="right1">
                @if ($rooms)
                    @foreach ($rooms as $room)
                    <div class="right" >
                        <div class="room-pic">
                            <img class="list" src="{{asset('RoomImg/'.$room->image)}}" alt="">
                        </div>
                        <div class="room-info">
                            <h5>{{ $room->room_name}} </h5>
                            <h6>Features</h6>
                                @php
                                    $feature = $room->room_features;
                                    $featuresArray = explode(',', $feature);
                                    $cutFeatures = implode(',', array_slice($featuresArray, 0, 3));
                                @endphp
                                <p class="roow-f">{{ $cutFeatures}} ...</p>
                            <h6>Aminities</h6>
                                @php
                                    $facility = $room->room_facilities;
                                    $facilityArray = explode(',', $facility);
                                    $cutFacility = implode(',', array_slice($facilityArray, 0, 3));
                                @endphp
                                <span class="room-aminities"> {{ $cutFacility}}... </span>
                            <h6>Guest</h6>
                            <span>{{ $room->adult }}  Adults / 
                                @if ($room->children)
                                    {{ $room->children}}
                                @else
                                    {{ '0' }}
                                @endif 
                                Children </span>
                            <h6>Room Price</h6>
                            <span>₱ {{number_format($room->price, 2);}} per night</span>
                        </div>
                        <div class="room-btn">
                                <button type="button"class="btn btn-success show-book" data-toggle="modal" data-target="#bookModal" value="{{Crypt::encryptstring($room->id)}}">Book Now</button>
                                <button type="button"class="more"><a href="{{ route('moredetails', [$room->id]) }}" style="text-decoration:none;color:black">More Details</a></button>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            
        </div>
        
        {{-- <div class="room-list">
            <div class="card">
                
            </div>
        </div> --}}
    </div>
    <script src="{{asset('new_js/jquery-3.7.1.min.js')}}"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="{{asset('new_js/booking.js?id=1')}}"></script>
    <script>
        function decodeJwtResponse(token) {
    let base64Url = token.split('.')[1];
    let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    let jsonPayload = decodeURIComponent(
      atob(base64)
        .split('')
        .map(function (c) {
          return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        })
        .join('')
    );
    return JSON.parse(jsonPayload);
  }
  window.onSignIn = googleUser => {
    var user = decodeJwtResponse(googleUser.credential);
    if(user){
      jQuery.noConflict();
      $.ajax({
        url: 'google',
        method: 'post',
        cache: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { email: user.email },
        success: function (data) {
          if(data.message == "success"){
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
              popup: 'colored-toast'
            },
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
          });
          Toast.fire({
            icon: 'success',
            title: "Login Sucessfully!"
          });
          window.location.href = 'rooms';
          }else if(data.message == 'notverified'){
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-right',
              iconColor: 'white',
              customClass: {
                popup: 'colored-toast'
              },
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true
            });
            Toast.fire({
              icon: 'error',
              title: "Email account not verified."
            });
          }else{
            console.log(data);
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-right',
              iconColor: 'white',
              customClass: {
                popup: 'colored-toast'
              },
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true
            });
            Toast.fire({
              icon: 'error',
              title: "You Are Not Authorize User."
            });
          }
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText)
        },
      });
    } else {
      alert('Not Valid');
    }
  };
        $(document).ready(function(){
            if($('#fromdate').val() && $('#enddate').val()){
              $('#start_date').val($('#fromdate').val());
              $('#end_date').val($('#enddate').val());
            }
            var currentDate = new Date();
            var currentDateString = currentDate.toISOString().split('T')[0];

           
            $('#start_date, #end_date').attr('min', currentDateString);
            $('#fromdate, #enddate').attr('min', currentDateString);

            $('#start_date').change(function() {

            var startDate = new Date($(this).val());

            startDate.setDate(startDate.getDate() + 1);

            var endMinDate = startDate.toISOString().split('T')[0];

            $('#end_date').attr('min', endMinDate);
            $('#days').text('0');
            $('#total_p').html('0')
            var startDateValue = $('#start_date').val();
                var endDateValue = $('#end_date').val();

                var startDate = new Date(startDateValue);
                var endDate = new Date(endDateValue);

                var differenceInTime = endDate.getTime() - startDate.getTime();
                var differenceInDays = Math.ceil(differenceInTime / (1000 * 3600 * 24));

                $('#days').text(differenceInDays);

                let total = differenceInDays * $('#real_price').val();

                $('#real_total').val(total);
                $('#total_p').html('₱ ' +total.toLocaleString('en-US'));
            });

            $('#end_date').change(function() {
                var startDateValue = $('#start_date').val();
                var endDateValue = $('#end_date').val();

                var startDate = new Date(startDateValue);
                var endDate = new Date(endDateValue);

                var differenceInTime = endDate.getTime() - startDate.getTime();
                var differenceInDays = Math.ceil(differenceInTime / (1000 * 3600 * 24));

                $('#days').text(differenceInDays);

                let total = differenceInDays * $('#real_price').val();

                $('#real_total').val(total);
                $('#total_p').html('₱ ' +total.toLocaleString('en-US'));
            });


            $('#fromdate').change(function() {
            var startDate = new Date($(this).val());

            startDate.setDate(startDate.getDate() + 1);

            var endMinDate = startDate.toISOString().split('T')[0];

            $('#enddate').attr('min', endMinDate);
            $('#enddate').val('');
            });

            $('#enddate').change(function() {
                var startDateValue = $('#fromdate').val();
                var endDateValue = $('#enddate').val();

                var startDate = new Date(startDateValue);
                var endDate = new Date(endDateValue);

                var differenceInTime = endDate.getTime() - startDate.getTime();
                var differenceInDays = Math.ceil(differenceInTime / (1000 * 3600 * 24));

                $('#start_date').val($('#fromdate').val());
                $('#end_date').val($('#enddate').val());
            });
            
        });
        
    </script>
@endsection