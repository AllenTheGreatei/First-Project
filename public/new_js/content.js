$('.browse').click(function () {
  $('#uploadImg').click();
});
$('.custom-file').on('change', '#uploadImg', function () {
  var file = this.files[0];
  $('#img').val(file.name);
  $('#img').attr('hidden', false);
});

$(document).ready(function () {
  function warning_msg(msg) {
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
      icon: 'warning',
      title: msg
    });
  }
  function success_msg(msg) {
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
      title: msg
    });
  }
  function error_msg(msg) {
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
      title: msg
    });
  }
  $('#admin_save_info').on('click', function (e) {
    e.preventDefault();

    let username = $('#admin_username').val();
    let fname = $('#admin_fname').val();
    let lname = $('#admin_lname').val();
    let email = $('#admin_email').val();
    var gmailPattern = /^[a-zA-Z0-9._%+-]+@gmail.com$/;

    if (!username || !fname || !lname || !email) {
      error_msg('Fields are required.');
    } else {
      if (!gmailPattern.test(email)) {
        error_msg('Invalid Email');
      } else {
        let formData = new FormData($('#admin-form')[0]);
        $.ajax({
          url: 'update_admin_prof',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          cache: false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          beforeSend: function () {
            $('#admin_save_info').prop('disabled', true);
            $('#admin_save_info').html('Saving..');
          },
          success: function (data) {
            if (data.message == 'success') {
              success_msg('Updated Successfully.');
            } else {
              error_msg('Failed to Update.');
              console.log(data);
            }
            $('#admin_save_info').prop('disabled', false);
            $('#admin_save_info').html('Save Changes');
          },
          error: function (xhr, status, error) {
            console.log(xhr.responseText);
          }
        });
      }
    }
  });

  $('#admin_save_pass').on('click', function (e) {
    e.preventDefault();
    let old = $('#admin_oldpass').val();
    let newpass = $('#admin_new_pass').val();
    let retypr = $('#admin_retypepass').val();

    if (!old || !newpass || !retypr) {
      warning_msg('Fields Required.');
    } else {
      let formData = new FormData($('#admin-form')[0]);
      $.ajax({
        url: 'change_pass',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        cache: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
          $('#admin_save_pass').prop('disabled', true);
          $('#admin_save_pass').html('Saving..');
        },
        success: function (data) {
          if (data.message == 'success') {
            $('#admin_oldpass').val('');
            $('#admin_new_pass').val('');
            $('#admin_retypepass').val('');
            success_msg('Password Updated Successfully.');
          } else if (data.message == 'inavlid_old_pass') {
            error_msg('Old Password not match');
          } else if (data.message == 'passnot_the_same') {
            error_msg('New Password and Retype-Password are not the same.');
          } else {
            error_msg('Failed to Update.');
            console.log(data);
          }
          $('#admin_save_pass').prop('disabled', false);
          $('#admin_save_pass').html('Save Changes');
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    }
  });
});

$('#admin_forgot_pass').on('click', function (e) {
  e.preventDefault();
  $.ajax({
    url: 'admin_send_otp',
    method: 'POST',
    dataType: 'json',
    cache: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (data) {
      if (data.message == 'success') {
        $('#admin-forgot-div').css('display', 'block');
      } else {
        console.log(data);
        error_msg('Opss! Something went wrong.');
      }
    },
    error: function (xhr, status, error) {
      console.log(xhr.responseText);
    }
  });

  $('#admin_save_forgot_pass').on('click', function (e) {
    e.preventDefault();
    let otp = $('#forgot_otp').val();
    let new_pass = $('#forgot_new_pass').val();
    let retypepass = $('#forgot_retype_pass').val();

    if (!otp || !new_pass || !retypepass) {
      warning_msg('Fields Required');
    } else {
      $.ajax({
        url: 'admin_confirm_otp',
        method: 'POST',
        data: $('#admin-form').serialize(),
        dataType: 'json',
        cache: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
          $('#admin_save_forgot_pass').prop('disabled', true);
          $('#admin_save_forgot_pass').html('Saving..');
        },
        success: function (data) {
          if (data.message == 'success') {
            success_msg('Password Change Successfully.');
            $('#admin-forgot-div').css('display', 'none');
            $('#forgot_otp').val('');
            $('#forgot_new_pass').val('');
            $('#forgot_retype_pass').val('');
          } else if (data.message == 'ivalid_otp') {
            error_msg('Invalid OTP');
          } else if (data.message == 'not_match') {
            error_msg('New Password and Retype-Password not match.');
          } else {
            error_msg('Opss! SOmething went wrong.');
            console.log(data);
          }
          $('#admin_save_forgot_pass').prop('disabled', false);
          $('#admin_save_forgot_pass').html('Save Changes');
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    }
  });
});
