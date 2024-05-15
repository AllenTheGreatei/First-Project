@section('title', 'Dashboard')
<div class="main-container">
    <div class="total_rooms">
        <h4 style="color:#787bff">Total Rooms <i class='text-success ml-2 fa-solid fa-chart-simple'></i></h4>
        <h1 class="text-secondary text-center mt-4 "> {{ count($rooms)}}</h1>
    </div>
    <div class="total_booked">
        <h4 style="color:#787bff">Total Booked <i class='text-success ml-2 fa-solid fa-chart-simple'></i></h4>
        <h1 class="text-secondary text-center mt-4 ">{{count($booked)}}</h1>
    </div>
    <div class="monthly_reveneu">
        <h4 style="color:#787bff">Current Month Revenue <i class='text-success ml-2 fa-solid fa-chart-simple'></i></h4>
        <h1 class="text-secondary text-center mt-4 ">₱ {{ number_format($total)}}</h1>
    </div>
    <div>
        <h4 style="color:#787bff">Total Room Category <i class='text-success ml-2 fa-solid fa-chart-simple'></i></h4>
        <h1 class="text-secondary text-center mt-4 ">{{ count($categories)}}</h1>
    </div>
    <div>
        <h4 style="color:#787bff">Total Room Aminities <i class='text-success ml-2 fa-solid fa-chart-simple'></i></h4>
        <h1 class="text-secondary text-center mt-4 ">{{ count( $facilities)}}</h1>
    </div>
    <div class="total_aminities">
        <h4 style="color:#787bff">Last Month Revenue <i class='text-success ml-2 fa-solid fa-chart-simple'></i></h4>
        <h1 class="text-secondary text-center mt-4 ">₱ {{ number_format($lastmonth_total)}}</h1>
    </div>
    <div class="total_category">
        <h4 style="color:#787bff">Total Room Feature <i class='text-success ml-2 fa-solid fa-chart-simple'></i></h4>
        <h1 class="text-secondary text-center mt-4 "> {{count($features)}}</h1>
    </div>

    <div class="total_category">
        <h4 style="color:#787bff">Total Registed Customer <i class='text-success ml-2 fa-solid fa-chart-simple'></i></h4>
        <h1 class="text-secondary text-center mt-4 "> {{count($users)}}</h1>
    </div>
    <div class="total_category">
        <h4 style="color:#787bff">Total Cancelled Bookings <i class='text-success ml-2 fa-solid fa-chart-simple'></i></h4>
        <h1 class="text-secondary text-center mt-4 "> {{count($cancel)}}</h1>
    </div>
    
    {{-- <div class="total_feature">
        
    </div>
    <div>

    </div> --}}
    {{-- <div></div>
    <div></div>
    <div></div> --}}
</div>