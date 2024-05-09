$(document).ready(function () {
  var roomFeatures = $('.room-aminities');
  var text = roomFeatures.text();
  var index = 0;
  var count = 0;

  // Find the index of the third comma
  while (count < 3 && index < text.length) {
    if (text[index] === ',') {
      count++;
    }
    index++;
  }
  // Cut the text at the index of the third comma
  if (index < text.length) {
    // roomFeatures.text(text.slice(0, index) + '...');
  }

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

  let array_checkout = [];
  $('#book_now').on('click', function () {
    let notice = $('#notice').val();
    var checkin = $('#start_date').val();
    var checkout = $('#end_date').val();
    function isOverlap(checkInDateInput, checkOutDateInput) {
      const checkInDate = new Date(checkInDateInput);
      const checkOutDate = new Date(checkOutDateInput);

      for (let i = 0; i < array_checkout.length; i++) {
        const existingCheckInDate = new Date(array_checkout[i][0]);
        const existingCheckOutDate = new Date(array_checkout[i][1]);

        // Check if either the check-in or check-out date falls within the range
        if (
          (existingCheckInDate >= checkInDate && existingCheckInDate <= checkOutDate) ||
          (existingCheckOutDate >= checkInDate && existingCheckOutDate <= checkOutDate)
        ) {
          return true; // Overlapping date range found
        }
      }
      return false; // No overlapping date range found
    }

    if (isOverlap(checkin, checkout)) {
      error_msg('This Date is not available.');
      return false;
    }

    let total_price = $('#real_total').val();
    let room_id = $('#idholder').val();

    const transaction = {
      checkin,
      checkout,
      total_price,
      room_id,
      notice
    };

    if (!checkin || !checkout) {
      warning_msg('Fields Required.');
    } else {
      $.ajax({
        url: 'booked',
        method: 'POST',
        data: { transaction },
        dataType: 'json',
        cache: false,
        headers: {
          X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
          $('#book_now').prop('disabled', true);
          $('#book_now').html('Loading...');
        },
        success: function (data) {
          if (data.message == 'success') {
            success_msg('Room Booked Successfully.');
          } else {
            console.log(data);
            error_msg('Opps! Something went wrong.');
          }
          $('#closebook').click();
          $('#book_now').prop('disabled', false);
          $('#book_now').html('Book Now');
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
          error_msg('Opss! Something went wrong.');
        }
      });
    }
  });

  $('.right1').on('click', '.show-book', function () {
    let notice = $('#notice').val();
    let id = $(this).val();
    console.log(id);
    var startDateValue = $('#start_date').val();
    var endDateValue = $('#end_date').val();
    $('#start_date').val('');
    $('#days').text('0');
    $('#end_date').val('');
    $('#total_p').html('0');
    $('#idholder').val(id);
    $.ajax({
      url: 'display_book',
      method: 'POST',
      data: { id: id, notice: notice },
      dataType: 'json',
      cache: false,
      headers: {
        X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (data) {
        $('.notavialablelist').empty();
        if (data.message == 'success') {
          $('#room_n').html(data.room.room_name);
          $('#room_p').html('₱ ' + data.room.price.toLocaleString('en-US') + ' /per night');
          $('#real_price').val(data.room.price);
          $('#r_img').attr('src', '/RoomImg/' + data.room.image);
          let list = data.booked;

          let i = 0;
          let j = 0;
          list.forEach(element => {
            array_checkout[i] = []; // Initialize the inner array at index i

            array_checkout[i][0] = element.check_in; // Assign check_in value to the inner array
            array_checkout[i][1] = element.check_out; // Assign check_out value to the inner array

            i++;
          });

          function formatDate(dateString) {
            var date = new Date(dateString);
            var options = { year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
          }

          list.forEach(element => {
            $('.notavialablelist').append(
              '<label class="form-label"><span class="text-danger">*</span> <span class="in">' +
                formatDate(element.check_in) +
                '</span> to <span class="end">' +
                formatDate(element.check_out) +
                '</span></label>'
            );
          });

          (function () {});
          $('.in').html(data.booked.check_in);
          $('.end').html(data.booked.check_out);
          // var startDate = new Date('2024-05-10');
          // var endDate = new Date('2024-05-15');

          // $('#start_date').on('input', function () {
          //   var selectedDate = new Date($(this).val());
          //   if (selectedDate >= startDate && selectedDate <= endDate) {
          //   }
          // });
        } else {
          console.log(data);
          error_msg('Opps! Something went wrong.');
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        error_msg('Opss! Something went wrong.');
      }
    });
  });

  $('.pay').on('click', function () {
    let id = $(this).val();
    $('#hiden_id').val(id);
    $.ajax({
      url: 'pay_display',
      method: 'POST',
      data: { id },
      dataType: 'json',
      cache: false,
      headers: {
        X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (data) {
        if (data.message == 'success') {
          $('#amount').val(data.amount);
        } else {
          console.log(data);
          error_msg('Opps! Something went wrong.');
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        error_msg('Opss! Something went wrong.');
      }
    });
  });

  $('#pay_now').on('click', function () {
    let id = $('#hiden_id').val();
    let cash = $('#cash').val();
    let amount = $('#amount').val();
    let ch = $('#change').val();
    let change = cash - amount;

    if (!cash) {
      warning_msg('Please Enter Cash.');
    } else if (cash < amount) {
      warning_msg('Cash is not Enough.');
    } else {
      $.ajax({
        url: 'pay',
        method: 'POST',
        data: { id: id, cash: cash, amount: amount, change: change },
        dataType: 'json',
        cache: false,
        headers: {
          X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          if (data.message == 'success') {
            $('#change').val(change);
            success_msg('Paid Successfully.');
          } else {
            console.log(data);
            error_msg('Opps! Something went wrong.');
          }
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
          error_msg('Opss! Something went wrong.');
        }
      });
    }
  });

  $('#enddate').on('change', function () {
    $('#notice').val(1);
    let enddate = $(this).val();
    let fromdate = $('#fromdate').val();

    if (!fromdate) {
      warning_msg('Please select check in date first.');
    } else {
      $.ajax({
        url: 'filterbydate',
        method: 'POST',
        data: { enddate: enddate, fromdate: fromdate },
        dataType: 'json',
        cache: false,
        headers: {
          X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          if (data.message == 'success') {
            $('.right1').empty();
            let rooms = data.rooms;
            if (rooms.length !== 0) {
              rooms.forEach(element => {
                // Assuming you have a container with class 'right'
                // Assuming you have a container with id 'myContainer'
                $('.right1').append(
                  `
                    <div class="right">
                        <div class="room-pic">
                            <img class="list" src="RoomImg/${element.image}" alt="">
                        </div>
                        <div class="room-info">
                            <h5>` +
                    element.room_name +
                    `</h5>
                            <h6>Features</h6>
                            <span>` +
                    element.room_features +
                    `</span>
                            <h6>Facilities</h6>
                            <span> ` +
                    element.room_facilities +
                    ` </span>
                            <h6>Guest</h6>
                            <span>` +
                    element.adult +
                    ` Adults / ` +
                    element.children +
                    `
                                
                                Children </span>
                            <h6>Room Price</h6>
                            <span>₱ ` +
                    element.price +
                    ` per night</span>
                        </div>
                        <div class="room-btn">
                            <button type="button" class="btn btn-success show-book" data-toggle="modal" data-target="#bookModal" value="${element.id}">Book Now</button>
                            <button type="button" class="more"><a href="moredetails/id=${element.id}" style="text-decoration:none;color:black">More Details</a></button>
                        </div>
                    </div>
                    `
                );
              });
            } else {
              console.log('test');
              $('.right1').append(
                `
                <div class="right" style="height: 10em; display: flex; justify-content: center; align-items: center;">
                    <h3 style="text-align: center; color: red;">No Available Rooms</h3>
                </div>
                `
              );
            }
          } else {
            console.log(data);
            error_msg('Opps! Something went wrong.');
          }
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
          error_msg('Opss! Something went wrong.');
        }
      });
    }
  });
  $('#Scategory').on('change', function () {
    $('#notice').val(1);
    let selected = $(this).val();
    $.ajax({
      url: 'filterby_category',
      method: 'POST',
      data: { selected },
      dataType: 'json',
      cache: false,
      headers: {
        X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (data) {
        if (data.message == 'success') {
          $('.right1').empty();
          let rooms = data.rooms;
          console.log(rooms);
          if (rooms.length !== 0) {
            rooms.forEach(element => {
              $('.right1').append(
                `
                      <div class="right">
                          <div class="room-pic">
                              <img class="list" src="RoomImg/${element.image}" alt="">
                          </div>
                          <div class="room-info">
                              <h5>` +
                  element.room_name +
                  `</h5>
                              <h6>Features</h6>
                              <span>` +
                  element.room_features +
                  `</span>
                              <h6>Facilities</h6>
                              <span> ` +
                  element.room_facilities +
                  ` </span>
                              <h6>Guest</h6>
                              <span>` +
                  element.adult +
                  ` Adults / ` +
                  element.children +
                  `
                                  
                                  Children </span>
                              <h6>Room Price</h6>
                              <span>₱ ` +
                  element.price +
                  ` per night</span>
                          </div>
                          <div class="room-btn">
                              <button type="button" class="btn btn-success show-book" data-toggle="modal" data-target="#bookModal" value="${element.id}">Book Now</button>
                              <button type="button" class="more"><a href="moredetails/${element.id}" style="text-decoration:none;color:black">More Details</a></button>
                          </div>
                      </div>
                      `
              );
            });
          } else {
            console.log('test');
            $('.right1').append(
              `
                  <div class="right" style="height: 10em; display: flex; justify-content: center; align-items: center;">
                      <h3 style="text-align: center; color: red;">No Available Rooms</h3>
                  </div>
                  `
            );
          }
        } else {
          console.log(data);
          error_msg('Opps! Something went wrong.');
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        error_msg('Opss! Something went wrong.');
      }
    });
  });

  $('#Sadult').on('keyup', function () {
    $('#notice').val(1);
    let adult = $(this).val();
    $.ajax({
      url: 'filterby_adult',
      method: 'POST',
      data: { adult },
      dataType: 'json',
      cache: false,
      headers: {
        X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (data) {
        if (data.message == 'success') {
          $('.right1').empty();
          let rooms = data.rooms;
          if (rooms.length !== 0) {
            rooms.forEach(element => {
              $('.right1').append(
                `
                      <div class="right">
                          <div class="room-pic">
                              <img class="list" src="RoomImg/${element.image}" alt="">
                          </div>
                          <div class="room-info">
                              <h5>` +
                  element.room_name +
                  `</h5>
                              <h6>Features</h6>
                              <span>` +
                  element.room_features +
                  `</span>
                              <h6>Facilities</h6>
                              <span> ` +
                  element.room_facilities +
                  ` </span>
                              <h6>Guest</h6>
                              <span>` +
                  element.adult +
                  ` Adults / ` +
                  element.children +
                  `
                                  
                                  Children </span>
                              <h6>Room Price</h6>
                              <span>₱ ` +
                  element.price +
                  ` per night</span>
                          </div>
                          <div class="room-btn">
                              <button type="button" class="btn btn-success show-book" data-toggle="modal" data-target="#bookModal" value="${element.id}">Book Now</button>
                              <button type="button" class="more"><a href="moredetails/${element.id}" style="text-decoration:none;color:black">More Details</a></button>
                          </div>
                      </div>
                      `
              );
            });
          } else {
            console.log('test');
            $('.right1').append(
              `
                  <div class="right" style="height: 10em; display: flex; justify-content: center; align-items: center;">
                      <h3 style="text-align: center; color: red;">No Available Rooms</h3>
                  </div>
                  `
            );
          }
        } else {
          console.log(data);
          error_msg('Opps! Something went wrong.');
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        error_msg('Opss! Something went wrong.');
      }
    });
  });

  $('#Schildren').on('keyup', function () {
    $('#notice').val(1);
    let children = $(this).val();
    let adult = $('#Sadult').val();
    $.ajax({
      url: 'filterby_age',
      method: 'POST',
      data: { children: children, adult: adult },
      dataType: 'json',
      cache: false,
      headers: {
        X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (data) {
        if (data.message == 'success') {
          $('.right1').empty();
          let rooms = data.rooms;
          if (rooms.length !== 0) {
            rooms.forEach(element => {
              $('.right1').append(
                `
                      <div class="right">
                          <div class="room-pic">
                              <img class="list" src="RoomImg/${element.image}" alt="">
                          </div>
                          <div class="room-info">
                              <h5>` +
                  element.room_name +
                  `</h5>
                              <h6>Features</h6>
                              <span>` +
                  element.room_features +
                  `</span>
                              <h6>Facilities</h6>
                              <span> ` +
                  element.room_facilities +
                  ` </span>
                              <h6>Guest</h6>
                              <span>` +
                  element.adult +
                  ` Adults / ` +
                  element.children +
                  `
                                  
                                  Children </span>
                              <h6>Room Price</h6>
                              <span>₱ ` +
                  element.price +
                  ` per night</span>
                          </div>
                          <div class="room-btn">
                              <button type="button" class="btn btn-success show-book" data-toggle="modal" data-target="#bookModal" value="${element.id}">Book Now</button>
                              <button type="button" class="more"><a href="moredetails/${element.id}" style="text-decoration:none;color:black">More Details</a></button>
                          </div>
                      </div>
                      `
              );
            });
          } else {
            console.log('test');
            $('.right1').append(
              `
                  <div class="right" style="height: 10em; display: flex; justify-content: center; align-items: center;">
                      <h3 style="text-align: center; color: red;">No Available Rooms</h3>
                  </div>
                  `
            );
          }
        } else {
          console.log(data);
          error_msg('Opps! Something went wrong.');
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        error_msg('Opss! Something went wrong.');
      }
    });
  });

  $('#refresh').on('click', function () {
    window.location.reload();
  });

  $('.Saminities').on('click', function () {
    $('.select').prop('checked', false);
    $(this).prop('checked', true);
    $('#notice').val(1);
    let selected = $(this).val();
    $.ajax({
      url: 'filterby_aminities',
      method: 'POST',
      data: { selected },
      dataType: 'json',
      cache: false,
      headers: {
        X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (data) {
        console.log(data);
        if (data.message == 'success') {
          $('.right1').empty();
          let rooms = data.rooms;
          console.log(rooms);
          if (rooms.length !== 0) {
            rooms.forEach(element => {
              $('.right1').append(
                `
                      <div class="right">
                          <div class="room-pic">
                              <img class="list" src="RoomImg/${element.image}" alt="">
                          </div>
                          <div class="room-info">
                              <h5>` +
                  element.room_name +
                  `</h5>
                              <h6>Features</h6>
                              <span>` +
                  element.room_features +
                  `</span>
                              <h6>Facilities</h6>
                              <span> ` +
                  element.room_facilities +
                  ` </span>
                              <h6>Guest</h6>
                              <span>` +
                  element.adult +
                  ` Adults / ` +
                  element.children +
                  `
                                  
                                  Children </span>
                              <h6>Room Price</h6>
                              <span>₱ ` +
                  element.price +
                  ` per night</span>
                          </div>
                          <div class="room-btn">
                              <button type="button" class="btn btn-success show-book" data-toggle="modal" data-target="#bookModal" value="${element.id}">Book Now</button>
                              <button type="button" class="more"><a href="moredetails/${element.id}" style="text-decoration:none;color:black">More Details</a></button>
                          </div>
                      </div>
                      `
              );
            });
          } else {
            console.log('test');
            $('.right1').append(
              `
                  <div class="right" style="height: 10em; display: flex; justify-content: center; align-items: center;">
                      <h3 style="text-align: center; color: red;">No Available Rooms</h3>
                  </div>
                  `
            );
          }
        } else {
          console.log(data);
          error_msg('Opps! Something went wrong.');
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        error_msg('Opss! Something went wrong.');
      }
    });
  });
});
