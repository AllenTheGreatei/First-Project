{{-- <link rel="stylesheet" href="{{ asset('new_css/dashboard.css') }}"> --}}
<div class="nav-container">
    <img id="menu-btn"src="{{asset('assets/img/menu.png')}}" alt="">
    <img id="user_img" src="{{asset('assets/img/user.png')}}" alt="">
    <div class="user_container">
        <div class="a">
            <img id="user_img2" src="{{asset('assets/img/user.png')}}" alt="">
            <div class="online"></div>
            <div>
                <h6>{{session('adminName')}}</h6>
                <p>Admin</p>
            </div>
        </div>
        <hr>
        <button id="admin-profile"><img id="profileicon"src="{{asset('assets/img/profile.png')}}" alt="">My Profile</button>
        <hr>
        <button id="admin-logout"><img id="lout"src="{{asset('assets/img/turn-off.png')}}" alt="">Logout</button>
    </div>
</div>