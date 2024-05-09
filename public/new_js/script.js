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

  if (!username || !fname || !lname || !email) {
  }
});
$(document).ready(function () {
  var activeBtnIndex = localStorage.getItem('activeBtnIndex');
  if (activeBtnIndex !== null) {
    // Remove active class from all buttons
    $('.nav-nav .nav-btn').removeClass('active');
    $('.nav-nav .a').removeClass('active1');
    // Add active class to the button with the stored index
    $('.nav-nav .nav-btn').eq(activeBtnIndex).addClass('active');
    $('.nav-nav .a').eq(activeBtnIndex).addClass('active1');
  }

  // Click event handler
  $('.nav-nav .nav-btn').click(function () {
    // Remove active class from all buttons
    $('.nav-nav .nav-btn').removeClass('active');
    $('.nav-nav .a').removeClass('active1');
    // Add active class to the clicked button
    $(this).addClass('active');
    $('.a', this).addClass('active1');
    // Store the index of the active button in local storage
    var index = $('.nav-nav .nav-btn').index(this);
    localStorage.setItem('activeBtnIndex', index);
  });

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
  //User login
  $('#login-btn').click(function (e) {
    e.preventDefault();
    let check = false;
    let email = $('#email').val();
    let password = $('#password').val();
    $('.inputs').each(function () {
      $(this).css('border-color', 'grey');
    });
    if (!email && !password) {
      warning_msg('Enter your email and password!');
      $('.inputs').each(function () {
        $(this).css('border-color', 'red');
      });
      check = true;
    } else if (!email) {
      warning_msg('Please enter your email!');
      $('#email').css('border-color', 'red');
      check = true;
    } else if (!password) {
      warning_msg('Please enter your password!');
      $('#password').css('border-color', 'red');
      check = true;
    }
    if (check) {
      return false;
    } else {
      $.ajax({
        url: '/login_ajax',
        method: 'POST',
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $('#login-form').serialize(),
        beforeSend: function () {
          $('#login-btn').prop('disabled', true);
          $('#login-btn').html('Validating...');
        },
        success: function (data) {
          if (data.message == 'success') {
            success_msg('Successfully Sign in');
            $('#login-btn').prop('disabled', false);
            window.location.href = 'home'; //
          } else if (data.message == 'max_attempt') {
            let second = data.time;
            $('#login-btn').prop('disabled', false);
            $('#max-attempt').html(`To many login attempt. Please try again later.(${second}s)`);
            let timer = setInterval(() => {
              second--;
              if (second > 0) {
                $('#max-attempt').html(`To many login attempt. Please try again later.(${second}s)`);
              } else {
                clearInterval(timer);
                // $('#login-btn').prop('disabled', false);
                $('#max-attempt').html('');
              }
            }, 1000);
          } else if (data.message == 'email') {
            console.log(data);
            $('#login-btn').prop('disabled', false);
            error_msg('Invalid Email Format!');
          } else if (data.message == 'notverified') {
            error_msg('Email account not verified.');
          } else {
            console.log(data);
            $('#login-btn').prop('disabled', false);
            error_msg('Invalid credentials!');
          }

          $('#email').val('');
          $('#password').val('');
          $('#login-btn').html('Sign in');
        },
        error: function (xhr, status, error) {
          console.error('Error:', xhr.responseText);
          error_msg('An error occurred. Please try again later.');
          $('#email').val('');
          $('#password').val('');
          $('#login-btn').prop('disabled', false);
          $('#login-btn').html('Sign in');
        }
      });
    }
  });

  $('.user_name').click(function (e) {
    e.preventDefault();
    $('.profile-box').css('display', function (_, currentValue) {
      return currentValue === 'none' ? 'block' : 'none';
    });
    $('.profile-box').css('pointer-events', function (_, currentValue) {
      return currentValue === 'none' ? 'auto' : 'none';
    });
  });

  $('#otp-submit').on('click', function () {
    let otp = $('#otp').val();
    if (!otp) {
      error_msg('Field Required');
    } else {
      $.ajax({
        url: 'validate_otp',
        method: 'POST',
        data: { otp },
        dataType: 'json',
        cache: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
          $('#otp-submit').prop('disabled', true);
          $('#otp-submit').html('Validating...');
        },
        success: function (data) {
          if (data.message == 'success') {
            success_msg('OPT Validated Successfully!');
            $('#otp').val('');
            window.location.href = 'forgot-pass-final';
          } else {
            console.log(data);
            error_msg('Something went wrong!');
          }
          $('#otp-submit').prop('disabled', false);
          $('#otp-submit').html('Submit');
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
          error_msg('An error occurred. Please try again later.');
        }
      });
    }
  });

  $('#sendotp').click(function (e) {
    e.preventDefault();
    var gmailPattern = /^[a-zA-Z0-9._%+-]+@gmail.com$/;
    let email = $('#email').val();
    if (!email) {
      warning_msg('Fields Required');
    } else {
      if (!gmailPattern.test(email)) {
        warning_msg('Invalid Email Format!');
      } else {
        $.ajax({
          url: 'sendOtp',
          method: 'POST',
          data: $('#formAuthentication').serialize(),
          dataType: 'json',
          cache: false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          beforeSend: function () {
            $('#sendotp').prop('disabled', true);
            $('#sendotp').html('Sending...');
          },
          success: function (data) {
            if (data.message == 'success') {
              success_msg('OPT Sent Successfully!');
              window.location.href = 'otp';
            } else {
              console.log(data);
              error_msg('Something went wrong!');
            }
            $('#sendotp').prop('disabled', false);
            $('#sendotp').html('Send OTP');
          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText);
            error_msg('An error occurred. Please try again later.');
          }
        });
      }
    }
  });

  //logout
  $('#logout').click(function () {
    Swal.fire({
      title: 'Are you sure?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Logout!'
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'logout_ajax',
          method: 'POST',
          dataType: 'json',
          cache: false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (data) {
            if (data.message == 'success') {
              success_msg('Logout Successfully!');
              window.location.href = '/';
            } else {
              error_msg('Something went wrong!'.data);
            }
          },
          error: function (xhr, status, error) {
            console.error('Error:', xhr.responseText);
            error_msg('An error occurred. Please try again later.');
          }
        });
      }
    });
  });
  // First Register
  let password_verify = false;
  $('#password').click(function () {
    $('.password-requirements').css('display', 'block');
  });
  $('#retype-password').click(function () {
    $('.password-requirements').css('display', 'none');
  });

  $('#password').keyup(function () {
    let password = $('#password').val();
    if (password.match(/[!`@#$%^&*]/g)) {
      $('#special').css('color', 'green');
      password_verify = true;
    } else {
      $('#special').css('color', 'red');
      password_verify = false;
    }
    if (password.match(/[0-9]/g)) {
      $('#number').css('color', 'green');
      password_verify = true;
    } else {
      $('#number').css('color', 'red');
      password_verify = false;
    }
    if (password.match(/[A-Z]/g)) {
      $('#capital').css('color', 'green');
      password_verify = true;
    } else {
      $('#capital').css('color', 'red');
      password_verify = false;
    }
    if (password.match(/[a-z]/g)) {
      $('#small').css('color', 'green');
      password_verify = true;
    } else {
      $('#small').css('color', 'red');
      password_verify = false;
    }
    if (password.length >= 8) {
      $('#eight_char').css('color', 'green');
      password_verify = true;
    } else {
      console.log('8 length');
      $('#eight_char').css('color', 'red');
      password_verify = false;
    }
  });

  $('#change_pass').on('click', function (e) {
    e.preventDefault();
    let match = true;
    let notnull = true;
    let new_pass = $('.newpassword').val();
    let retype_pass = $('.retype-password').val();
    if (!new_pass || !retype_pass) {
      warning_msg('Fields Required.');
      notnull = false;
    } else {
      if (new_pass !== retype_pass) {
        warning_msg('New Password and Retype-Password not match.');
        match = false;
      }
    }
    if (password_verify && match && notnull) {
      $('.password-requirements').css('display', 'none');
      $.ajax({
        url: 'user-change-password',
        method: 'POST',
        data: $('#changepassform').serialize(),
        dataType: 'json',
        cache: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
          $('#change_pass').prop('disabled', true);
          $('#change_pass').html('Saving...');
        },
        success: function (data) {
          if (data.message == 'success') {
            success_msg('Password Change Successfully');
            window.location.href = 'login';
          } else {
            error_msg('Opps! Something went wrong');
            console.log(data);
          }

          $('#change_pass').prop('disabled', false);
          $('#change_pass').html('Save');
        },
        error: function (xhr, status, error) {
          console.error('Error:', xhr.responseText);
          error_msg('An error occurred. Please try again later.');
        }
      });
    } else {
      $('.password-requirements').css('display', 'block');
    }
  });

  $('#Register-btn').on('click', function (e) {
    e.preventDefault();
    var isValid = true;
    var gmailPattern = /^[a-zA-Z0-9._%+-]+@gmail.com$/;
    var isnotblank = false;
    let password = $('#password').val();
    let email = $('#email').val();
    let contact = $('#contactNo').val();
    let retypepassword = $('#retype-password').val();
    let terms_conditions = $('#terms-conditions').prop('checked');
    // check if for all fields
    $('#Register_form .input').each(function () {
      $(this).css('border-color', 'lightgrey');
      if (!$(this).val()) {
        $(this).css('border-color', 'red');
        warning_msg('Please fill all fields!');
        isValid = false;
        isnotblank = true;
        return false;
      }
    });

    if (!isnotblank) {
      if (!password_verify) {
        warning_msg('Password is not valid!');
      }
      if (!gmailPattern.test(email)) {
        isValid = false;
        warning_msg('Invalid Email Format!');
      }
      // check if password are the same
      if (password !== retypepassword) {
        isValid = false;
        warning_msg('Password provided are not the same.');
        $('#password').css('border-color', 'red');
        $('#retype-password').css('border-color', 'red');
      } else {
        $('#password').css('border-color', 'lightgrey');
        $('#retype-password').css('border-color', 'lightgrey');
      }
      // check if agree in policy
      if (!terms_conditions) {
        isValid = false;
        warning_msg('Please agree with our terms and condition.');
      }

      if (contact.length !== 11) {
        isValid = false;
        warning_msg('Contact Number must be 11 character.');
      }
    }

    if (isValid && !isnotblank && password_verify) {
      $('.password-requirements').css('display', 'none');
      $.ajax({
        url: 'register',
        method: 'POST',
        data: $('#Register_form').serialize(),
        dataType: 'json',
        cache: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
          $('#Register-btn').prop('disabled', true);
          $('#Register-btn').html('Registering...');
        },
        success: function (data) {
          if (data.message == 'success') {
            $('#verifyinfo').css('display', 'flex');
            success_msg('Register Successfully');
            $('#Register_form .input').each(function () {
              $(this).val('');
            });
            $('#terms-conditions').prop('checked', false);
          } else if (data.message == 'exist') {
            error_msg('Email is already taken.');
          } else if (data.message == 'failed') {
            error_msg('Failed to register');
          } else {
            error_msg('Opps! Something went wrong');
            console.log(data);
          }

          $('#Register-btn').prop('disabled', false);
          $('#Register-btn').html('Sign Up');
        },
        error: function (xhr, status, error) {
          console.error('Error:', xhr.responseText);
          error_msg('An error occurred. Please try again later.');
        }
      });
    } else {
      $('.password-requirements').css('display', 'block');
    }
  });

  // Admin Login
  $('#admin-login-btn').on('click', function (e) {
    e.preventDefault();
    let email = $('#admin-email').val();
    let password = $('#admin-password').val();
    var isNull = false;
    if (!email || !password) {
      isNull = true;
      warning_msg('Please input all fields.');
    }
    if (!isNull) {
      $.ajax({
        url: 'admin-ajax-login',
        method: 'POST',
        data: {
          email: email,
          password: password
        },
        dataType: 'json',
        cache: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
          $('#admin-login-btn').prop('disabled', true);
          $('#admin-login-btn').html('Logging In');
        },
        success: function (data) {
          console.log(data);
          if (data.message == 'success') {
            success_msg('Login Successfully.');
            window.location.href = 'dashboard';
          } else if (data.message == 'max_attempt') {
            let second = data.time;
            $('#admin-login-btn').prop('disabled', false);
            $('#admin-max-attempt').html(`To many login attempt. Please try again later.(${second}s)`);
            let timer = setInterval(() => {
              second--;
              if (second > 0) {
                $('#admin-max-attempt').html(`To many login attempt. Please try again later.(${second}s)`);
              } else {
                clearInterval(timer);
                // $('#login-btn').prop('disabled', false);
                $('#admin-max-attempt').html('');
              }
            }, 1000);
          } else if (data.message == 'notverified') {
            error_msg('Email account not verified.');
          } else {
            error_msg('Invalid Credentials.');
            console.log(data);
          }
          $('#admin-login-btn').prop('disabled', false);
          $('#admin-login-btn').html('Login');
        },
        error: function (xhr, status, error) {
          console.error('Error:', xhr.responseText);
          error_msg('An error occurred. Please try again later.');
        }
      });
    }
  });

  $('#admin-logout').click(function () {
    Swal.fire({
      title: 'Are you sure?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Logout!'
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'logout_ajax',
          method: 'POST',
          dataType: 'json',
          cache: false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (data) {
            if (data.message == 'success') {
              success_msg('Logout Successfully!');
              window.location.href = 'admin-login';
            } else {
              error_msg('Something went wrong!'.data);
            }
          },
          error: function (xhr, status, error) {
            console.error('Error:', xhr.responseText);
            error_msg('An error occurred. Please try again later.');
          }
        });
      }
    });
  });
  // Places
  $.getJSON('json/philippine_provinces_cities_municipalities_and_barangays_2016_v2.json', function (data) {
    let provinceArray = [];
    let municipalitiesArray = [];
    let barangayArray = [];
    let onchangeProvince;
    let onchangeMunicipal;
    for (const key in data) {
      if (data.hasOwnProperty(key)) {
        let province = data[key].province_list;
        const sortedKeys = Object.keys(province).sort();
        sortedKeys.forEach(key => {
          provinceArray.push(key);
        });
      }
    }
    provinceArray.sort().forEach(element => {
      $('#province').append('<option value="' + element + '">' + element + '</option>');
    });

    $('#province').on('change', function () {
      onchangeProvince = $(this).val();
      for (const key in data) {
        if (data.hasOwnProperty(key)) {
          for (const province in data[key].province_list) {
            if (province == onchangeProvince) {
              let monicipalites = data[key].province_list[province].municipality_list;
              const sortedKeyss = Object.keys(monicipalites).sort();
              municipalitiesArray = [];
              sortedKeyss.forEach(key => {
                municipalitiesArray.push(key);
              });
            }
          }
        }
      }
      $('#municipal').empty();
      municipalitiesArray.sort().forEach(element => {
        $('#municipal').append('<option value="' + element + '">' + element + '</option>');
      });
    });

    $('#municipal').on('change', function () {
      onchangeMunicipal = $(this).val();
      for (const key in data) {
        if (data.hasOwnProperty(key)) {
          for (const province in data[key].province_list) {
            if (province == onchangeProvince) {
              for (const municipal in data[key].province_list[province].municipality_list) {
                if (municipal == onchangeMunicipal) {
                  let barangay = data[key].province_list[province].municipality_list[municipal].barangay_list;
                  barangayArray = [];
                  barangay.forEach(element => {
                    barangayArray.push(element);
                  });
                }
              }
            }
          }
        }
      }
      $('#barangay').empty();
      barangayArray.sort().forEach(element => {
        $('#barangay').append('<option value="' + element + '">' + element + '</option>');
      });
    });
  });
});
