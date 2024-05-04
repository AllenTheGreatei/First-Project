<link rel="stylesheet" href="{{ asset('new_css/dashboard.css') }}">

<div class="main-container">
    <img id="arrow-btn"src="{{asset('assets/img/left-arrow.png')}}" alt="">
    <div class="container">
        <h1 id="header">Admin</h1>
        <div class="sidebar-menu">
            <p class="menu">MENU</p>
            <hr>
            <button id="dashboard"class="menubtn side-btn"><img class="sidebar-icon" src="{{asset('assets/img/dashboard.png')}}" alt="">Dashboards</button>
            <p class="menu">MENU</p>
            <hr>
            <button id="roombtn"class="menubtn side-btn"><img class="sidebar-icon" src="{{asset('assets/img/bed.png')}}" alt="">Manage Rooms<i class="fas fa-angle-down ml-3"></i></button>
            
            <li id="viewroom"class="li menubtn">View Room</li>
            <li id="addnewroom"class="li menubtn">Add New Room</li>
            <li id="category"class="li menubtn">Room Category</li>
            <li id="facility"class="li menubtn">Facility</li>
            <li id="feature"class="li menubtn">Feature</li>
            <button id="bookedbtn"class="menubtn side-btn"><img class="sidebar-icon" src="{{asset('assets/img/agenda.png')}}" alt="">Booked</button>
            <button class="menubtn side-btn"><img class="sidebar-icon" src="{{asset('assets/img/history.png')}}" alt="">History</button>
            <button class="menubtn side-btn"><img class="sidebar-icon" src="{{asset('assets/img/settings.png')}}" alt="">Settings</button>
        </div>
    </div>
</div>

<script>
    var roomRoute = '{{ route("room") }}';
    var bookedRoute = '{{ route("booked") }}';
    var dashboardRoute = '{{ route("dashboardbtn") }}';
    var addroomRoute = '{{ route("add_room") }}';
    var viewroomRoute = '{{ route("view_room") }}';
    var category = '{{ route("category") }}';
    var facilityRoute = '{{ route("facility") }}';
    var facilitytb = '{{ route("facilitytable") }}';
    var feature = '{{ route("feature") }}';
    var featuretable = '{{ route("featuretable") }}';
    var roomtable = '{{ route("roomtable") }}';

</script>