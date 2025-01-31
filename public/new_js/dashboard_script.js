//user image

// $('.dashboard-container').load(dashboardRoute);
$(document).click(function (event) {
  if (
    !$(event.target).closest('.user_container').length &&
    !$(event.target).is('.user_container') &&
    !$(event.target).is('#user_img')
  ) {
    $('.user_container').css('display', 'none');
    $('.user_container').css('pointer-events', 'none');
  }
});

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
    if ($(this).attr('id') === 'roombtn') {
      if ($('.li').css('display') === 'none') {
        $('.li').css('display', 'block');
        $('.side-btn').each(function () {
          $(this).removeClass('active');
        });
        $(this).addClass('active');
      } else {
        $('.li').css('display', 'none');
        $(this).removeClass('active');
      }
    } else {
      $('.side-btn').each(function () {
        $(this).removeClass('active');
      });
      $('.li').each(function () {
        $(this).removeClass('active');
      });
      $(this).addClass('active');
      $('.li').css('display', 'none');
    }
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
  // $('#roombtn').click(function () {
  //   $('.li').css('display', 'block');
  // });
  // $('#roombtn').on('click', function () {
  //   if ($('.li').css('display', 'none')) {
  //     $('.li').css('display', 'block');
  //   } else {
  //     $('.li').css('display', 'none');
  //   }
  // });

  $('#user_img').on('click', function () {
    $('.user_container').css('display', function (_, currentValue) {
      return currentValue === 'none' ? 'block' : 'none';
    });
    $('.user_container').css('pointer-events', function (_, currentValue) {
      return currentValue === 'none' ? 'auto' : 'none';
    });
  });

  $('#addnewroom').click(function () {
    $('.dashboard-container').empty();
    $('.dashboard-container').load(addroomRoute);

    // $('#user_img').on('click', function () {
    //   $('.user_container').css('display', function (_, currentValue) {
    //     return currentValue === 'none' ? 'block' : 'none';
    //   });
    //   $('.user_container').css('pointer-events', function (_, currentValue) {
    //     return currentValue === 'none' ? 'auto' : 'none';
    //   });
    // });
  });

  $('#viewroom').on('click', function () {
    $('.dashboard-container').empty();
    $('.dashboard-container').load(viewroomRoute);
  });

  $('#category').on('click', function () {
    $('.dashboard-container').empty();
    $('.dashboard-container').load(category);
  });

  $('#facility').on('click', function () {
    $('.dashboard-container').empty();
    $('.dashboard-container').load(facilityRoute);
  });

  $('#feature').on('click', function () {
    $('.dashboard-container').empty();
    $('.dashboard-container').load(feature);
  });

  $('#admin-profile').on('click', function () {
    $('.dashboard-container').empty();
    $('.dashboard-container').load(admin_profile);
    $('.user_container').css('display', 'none');
    $('.user_container').css('pointer-events', 'none');
  });

  $('#dashboard').on('click', function () {
    $('.dashboard-container').empty();
    $('.dashboard-container').load(dashboardRoute);
  });

  $('#bookedbtn').on('click', function () {
    $('.dashboard-container').empty();
    $('.dashboard-container').load(bookedRoute);
  });

  $('#report').on('click', function () {
    $('.dashboard-container').empty();
    $('.dashboard-container').load(reports);
  });

  $('#historybtn').on('click', function () {
    $('.dashboard-container').empty();
    $('.dashboard-container').load(historys);
  });
});
