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
  //
  //
  //
  //
  $('#start_date').on('change', function () {
    var startDate = new Date($('#start_date').val());
    if (!isNaN(startDate.getTime())) {
      // Check if a valid date is entered
      var endDate = new Date(startDate);
      endDate.setDate(endDate.getDate() + 1); // Add one day to the start date
      var formattedEndDate = endDate.toISOString().split('T')[0]; // Format the date as YYYY-MM-DD
      $('#end_date').val(formattedEndDate); // Set the value of the end date input field
    }
  });
  let array_checkout = [];
  // $('#book_now').on('click', function (e) {
  //   e.preventDefault();
  //   let notice = $('#notice').val();
  //   var checkin = $('#start_date').val();
  //   var checkout = $('#end_date').val();
  //   function isOverlap(checkInDateInput, checkOutDateInput) {
  //     const checkInDate = new Date(checkInDateInput);
  //     const checkOutDate = new Date(checkOutDateInput);

  //     for (let i = 0; i < array_checkout.length; i++) {
  //       const existingCheckInDate = new Date(array_checkout[i][0]);
  //       const existingCheckOutDate = new Date(array_checkout[i][1]);

  //       // Check if either the check-in or check-out date falls within the range
  //       if (
  //         (existingCheckInDate >= checkInDate && existingCheckInDate <= checkOutDate) ||
  //         (existingCheckOutDate >= checkInDate && existingCheckOutDate <= checkOutDate)
  //       ) {
  //         return true; // Overlapping date range found
  //       }
  //     }
  //     return false; // No overlapping date range found
  //   }

  //   if (isOverlap(checkin, checkout)) {
  //     error_msg('This Date is not available.');
  //     return false;
  //   }

  //   let total_price = $('#real_total').val();
  //   let room_id = $('#idholder').val();

  //   const transaction = {
  //     checkin,
  //     checkout,
  //     total_price,
  //     room_id,
  //     notice
  //   };

  //   if (!checkin || !checkout) {
  //     warning_msg('Fields Required.');
  //   } else {
  //     $.ajax({
  //       url: 'session',
  //       method: 'POST',
  //       data: { transaction: transaction, _token: csrf_token },
  //       dataType: 'json',
  //       cache: false,
  //       headers: {
  //         X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
  //       },
  //       beforeSend: function () {
  //         $('#book_now').prop('disabled', true);
  //         $('#book_now').html('Loading...');
  //       },
  //       success: function (data) {
  //         if (data.message == 'success') {
  //         } else {
  //           console.error('Error:', data);
  //         }
  //         // $('#closebook').click();
  //         $('#book_now').prop('disabled', false);
  //         $('#book_now').html('Book Now');
  //       },
  //       error: function (xhr, status, error) {
  //         console.log(xhr.responseText);
  //         error_msg('Opss! Something went wrong.');
  //       }
  //     });
  //   }
  // });

  //
  //
  //
  //
  //

  var csrf_token = $('meta[name="csrf-token"]').attr('content');
  $('.right1').on('click', '.show-book', function () {
    let notice = $('#notice').val();
    let id = $(this).val();
    var startDateValue = $('#start_date').val();
    var endDateValue = $('#end_date').val();

    if (!$('#fromdate').val() && !$('#enddate').val()) {
      $('#start_date').val('');
      $('#end_date').val('');
    } else {
      var startDateValue = $('#start_date').val();
      var endDateValue = $('#end_date').val();

      var startDate = new Date(startDateValue);
      var endDate = new Date(endDateValue);

      var differenceInTime = endDate.getTime() - startDate.getTime();
      var differenceInDays = Math.ceil(differenceInTime / (1000 * 3600 * 24));

      $('#days').text(differenceInDays);

      let total = differenceInDays * $('#real_price').val();

      $('#real_total').val(total);
      $('#total_p').html('₱ ' + total.toLocaleString('en-US'));
    }

    $('#days').text('0');
    $('#total_p').html('0');
    $('#idholder').val(id);
    $.ajax({
      url: 'display_book',
      method: 'POST',
      data: { id: id, notice: notice, _token: csrf_token },
      dataType: 'json',
      cache: false,
      headers: {
        X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (data) {
        $('.notavialablelist').empty();
        if (data.message == 'success') {
          $('#room_n').html(data.room.room_name);
          $('#r_name').val(data.room.room_name);
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

          if ($('#fromdate').val() && $('#enddate').val()) {
            var startDateValue = $('#start_date').val();
            var endDateValue = $('#end_date').val();

            var startDate = new Date(startDateValue);
            var endDate = new Date(endDateValue);

            var differenceInTime = endDate.getTime() - startDate.getTime();
            var differenceInDays = Math.ceil(differenceInTime / (1000 * 3600 * 24));

            $('#days').text(differenceInDays);

            let total = differenceInDays * $('#real_price').val();

            $('#real_total').val(total);
            $('#total_p').html('₱ ' + total.toLocaleString('en-US'));
          }

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
    $('#Sadult').val('');
    $('#Schildren').val('');
    $('.Saminities').prop('checked', false);
    $('#select').prop('checked', false);
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
        beforeSend: function () {
          $('.right1').empty();
          $('.right1').append(`
          <div class="right">
            <h4 style="margin-top:.5em;margin-left:2em">Searching...</h4>
          </div>
          `);
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
    $('#enddate').val('');
    $('#fromdate').val('');
    $('#Sadult').val('');
    $('#Schildren').val('');
    $('.Saminities').prop('checked', false);
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
      beforeSend: function () {
        $('.right1').empty();
        $('.right1').append(`
        <div class="right">
          <h4 style="margin-top:.5em;margin-left:2em">Searching...</h4>
        </div>
        `);
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
    $('#enddate').val('');
    $('#fromdate').val('');
    $('#Schildren').val('');
    $('.Saminities').prop('checked', false);
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
      beforeSend: function () {
        $('.right1').empty();
        $('.right1').append(`
        <div class="right">
          <h4 style="margin-top:.5em;margin-left:2em">Searching...</h4>
        </div>
        `);
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
    $('#enddate').val('');
    $('#fromdate').val('');
    $('.Saminities').prop('checked', false);
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
      beforeSend: function () {
        $('.right1').empty();
        $('.right1').append(`
        <div class="right">
          <h4 style="margin-top:.5em;margin-left:2em">Searching...</h4>
        </div>
        `);
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
    $('#enddate').val('');
    $('#fromdate').val('');
    $('#Sadult').val('');
    $('#Schildren').val('');
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
      beforeSend: function () {
        $('.right1').empty();
        $('.right1').append(`
        <div class="right">
          <h4 style="margin-top:.5em;margin-left:2em">Searching...</h4>
        </div>
        `);
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

  $('#search').on('keyup', function () {
    //   let search = $(this).val();
    //   $.ajax({
    //     url: 'search',
    //     method: 'POST',
    //     data: { search },
    //     dataType: 'json',
    //     cache: false,
    //     headers: {
    //       X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
    //     },
    //     beforeSend: function () {
    //       $('.room_tbody').empty();
    //       $('.room_tbody').append(`
    //         <tr>
    //           <td>Searching..</td>
    //         </tr>
    //       `);
    //     },
    //     success: function (data) {
    //       // console.log(data);
    //       if (data.message == 'success') {
    //         $('.room_tbody').empty();
    //         let users = data.users;
    //         let booked = data.booked;
    //         let rooms = data.rooms;
    //         let no = 1;
    //         console.log(users);
    //         users.forEach(element1 => {
    //           $('.room_tbody').append(
    //             `
    //               <tr>
    //               <td>` +
    //               no +
    //               `</td>
    //               <td>` +
    //               booked.forEach(element2 => {
    //                 if (element1.id === element2.user_id) {
    //                   element1.first_name;
    //                   return false;
    //                 }
    //               }) +
    //               `</td>
    //               </tr>
    //             `
    //           );
    //           no++;
    //         });
    //       }
    //     },
    //     error: function (xhr, status, error) {
    //       console.log(xhr.responseText);
    //       error_msg('Opss! Something went wrong.');
    //     }
    //   });
  });

  $('.cancel-show').on('click', function (e) {
    $('#idhold').val($(this).val());
  });

  $('#cancel').on('click', function (e) {
    e.preventDefault();
    let id = $('#idhold').val();
    let reason = $('#reason').val();
    if (reason) {
      $.ajax({
        url: 'cancelbook',
        method: 'post',
        data: { reason: reason, id: id, _token: csrf_token },
        beforeSend: function () {
          $('#cancel').prop('disabled', true);
          $('#cancel').html('Loading...');
        },
        success: function (data) {
          console.log(data);
          if (data.message == 'success') {
            $('#c').click();
            //
          } else {
            //
          }
          $('#cancel').prop('disabled', false);
          $('#cancel').html('Submit');
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    }
  });

  $('.view-reason').on('click', function (e) {
    e.preventDefault();
    let id = $(this).val();
    $('#idhold2').val(id);
    $.ajax({
      url: 'view-reason',
      method: 'post',
      data: { id: id, _token: csrf_token },
      success: function (data) {
        $('#reason2').val(data.data);
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
      }
    });
  });

  $('#cancelreal').on('click', function (e) {
    e.preventDefault();
    let id = $('#idhold2').val();
    $.ajax({
      url: 'cancel-real',
      method: 'post',
      data: { id: id, _token: csrf_token },
      success: function (data) {
        if (data.message == 'success') {
          $('#c').click();
          success_msg('Cancelled Successfully!');
        } else {
          error_msg('Ops! Something went wrong!');
          console.log(data);
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
      }
    });
  });

  $('.out').on('click', function () {
    let id = $(this).val();
    Swal.fire({
      title: 'Are you sure?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes Checkout!'
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'out',
          method: 'post',
          data: { id: id, _token: csrf_token },
          success: function (data) {
            if (data.message == 'success') {
              success_msg('Checkout Successfully!');
            } else {
              error_msg('Ops! Something went wrong!');
              console.log(data);
            }
          },
          error: function (xhr, status, error) {
            console.log(xhr.responseText);
          }
        });
      }
    });
  });

  $('.can').on('click', function () {
    let id = $(this).val();

    Swal.fire({
      title: 'Are you sure?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes Cancel!'
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'can',
          method: 'post',
          data: { id: id, _token: csrf_token },
          success: function (data) {
            if (data.message == 'success') {
              success_msg('Cancelled Successfully!');
            } else {
              error_msg('Ops! Something went wrong!');
              console.log(data);
            }
          },
          error: function (xhr, status, error) {
            console.log(xhr.responseText);
          }
        });
      }
    });
  });
});
