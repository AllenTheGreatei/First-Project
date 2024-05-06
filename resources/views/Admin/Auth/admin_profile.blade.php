<link rel="stylesheet" href="{{ asset('new_css/admin_profile.css')}}">
<div class="adminprofile-container">
    <div class="wraps">
        <h4>My Profile</h4>
    </div>
    <div class="containers">
        <form id="admin-form">

            <label for="" class="form-label">Profile</label><br>
            <img id="admin_img" src="{{asset('assets/img/avatars/1.png')}}" alt=""><br>
            <div class="custom-file mt-3" style="width:15em">
            <input type="file" class="custom-file-input" id="uploadImg"  name="image">
            <label class="custom-file-label" for="customFile">Choose file</label>
            </div><br>
            <label for="" class="form-label mt-3">Personal Information</label>
            <hr>
            <label for="" class="form-label">Username</label>
            <input type="text" class="form-control" id="admin_username" name="admin_username" value="{{ $admin->username }}">
            <label for="" class="form-label">First Name</label>
            <input type="text" class="form-control" id="admin_fname" name="admin_fname" value="{{ $admin->first_name }}">
            <label for="" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="admin_lname"
            name="admin_lname" value="{{ $admin->last_name}}">
            <label for="" class="form-label">Email Address</label>
            <input type="text" class="form-control" id="admin_email" name="admin_email" value="{{ $admin->email }}">
            <button class="btn btn-primary mt-3" id="admin_save_info"> Save Changes</button><br>

            <label for="" class="form-label mt-4">Password and Security</label>
            <hr>
            <label for="" class="form-label">Old Password</label>
            <input type="password" class="form-control" id="admin_oldpass" name="admin_oldpass">
            <label for="" class="form-label">New Password</label>
            <input type="password" class="form-control" id="admin_new_pass" name="admin_new_pass">
            <label for="" class="form-label">Retype-Password</label>
            <input type="password" class="form-control" id="admin_retypepass" name="admin_retypepass"> 

            <button class="btn btn-primary mt-3" id="admin_save_pass"> Save Changes</button><br>
            <label for="" class="form-label mt-3"><a id="admin_forgot_pass" href="">Forgot Password?</a></label>

        </form>

    </div>
</div>

<script src="{{asset('new_js/content.js')}}"></script>