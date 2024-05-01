//user image

// $('.dashboard-container').load(dashboardRoute);

$(document).ready(function () {
  $('#arrow-btn').click(function () {
    $('.container').css('display', 'none');
    $('.nav-container').css('width', '96vw');
    $('.nav-container').css('left', '2em');
    $('.dashboard-container').css('width', '96vw');
    $('.dashboard-container').css('left', '2em');
    $('#menu-btn').css('display', 'block');
    $('#arrow-btn').css('display', 'none');
  });

  $('#menu-btn').click(function () {
    if (window.matchMedia('(max-width: 767px)').matches) {
      $('.container').css('display', 'block');
      $('.container').css('width', '60vw');
      $('#arrow-btn').css('z-index', '150');
      $('#menu-btn').css('display', 'none');
      $('#arrow-btn').css('display', 'block');
      $('#arrow-btn').css('left', '57vw');
    } else {
      $('.container').css('display', 'block');
      $('.container').css('width', '18vw');
      $('#arrow-btn').css('z-index', '200');
      $('#menu-btn').css('display', 'none');
      $('#arrow-btn').css('display', 'block');
      $('#arrow-btn').css('left', '17vw');
      $('.nav-container').css('width', '78vw');
      $('.nav-container').css('left', '20em');
      $('.dashboard-container').css('width', '78vw');
      $('.dashboard-container').css('left', '20em');
    }
  });

  $('.side-btn').click(function () {
    $('.side-btn').each(function () {
      $(this).removeClass('active');
    });
    $('.li').each(function () {
      $(this).removeClass('active');
    });
    $(this).addClass('active');
    $('.li').css('display', 'none');
  });

  $('.li').click(function () {
    $('.side-btn').each(function () {
      $(this).removeClass('active');
    });
    $('.li').each(function () {
      $(this).removeClass('active');
    });
    $(this).addClass('active');
  });

  // $('.dashboard-container').load(viewroomRoute);
  $('#roombtn').click(function () {
    $('.li').css('display', 'block');
  });

  $('#user_img').on('click', function () {
    $('.user_container').css('display', function (_, currentValue) {
      return currentValue === 'none' ? 'block' : 'none';
    });
    $('.user_container').css('pointer-events', function (_, currentValue) {
      return currentValue === 'none' ? 'auto' : 'none';
    });
  });
  $('#addnewroom').click(function () {
    $('.dashboard-container').load(addroomRoute);
    $('#user_img').on('click', function () {
      $('.user_container').css('display', function (_, currentValue) {
        return currentValue === 'none' ? 'block' : 'none';
      });
      $('.user_container').css('pointer-events', function (_, currentValue) {
        return currentValue === 'none' ? 'auto' : 'none';
      });
    });
  });

  $('#viewroom').click(function () {
    $('.dashboard-container').load(viewroomRoute);
  });
});

// $('#dashboard').click(function () {
//   $('.dashboard-container').load(dashboardRoute);
// });
