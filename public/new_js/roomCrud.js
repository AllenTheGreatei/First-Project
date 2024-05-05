// const { error } = require('jquery');
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

  $('.delete-room-btn').on('click', function () {
    let room_id = $(this).val();
    Swal.fire({
      title: 'Are you sure?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Delete!'
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'delete_room',
          method: 'POST',
          data: { room_id },
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          dataType: 'json',
          cache: false,
          success: function (data) {
            if (data.message == 'success') {
              success_msg('Deleted Successfully.');
              $('.row' + room_id).hide();
            } else if (data.message == 'error') {
              error_msg('Failed to Delete.');
            } else {
              error_msg('Opps! Something went wrong.');
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

  $('.update-room-btn').on('click', function () {
    $('option[data-dynamic="true"]').remove();
    let room_id = $(this).val();
    $('#img').val();
    $('#r_name').val();
    $('#r_price').val();
    $('#r_category').val();
    $('#r_facilities').val();
    $('#r_features').val();
    $('#r_adult').val();
    $('#r_children').val();
    $('#r_description').val();
    $.ajax({
      url: 'retrive_room',
      method: 'POST',
      data: { room_id },
      dataType: 'json',
      cache: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (data) {
        if (data.message == 'success') {
          $('#img').val(data.room.r_img);
          $('#r_name').val(data.room.r_name);
          $('#r_price').val(data.room.r_price);
          let category = $('<option>', {
            value: data.room.r_category,
            text: data.room.r_category,
            'data-dynamic': 'true'
          });
          $('#r_category').append(category);
          category.prop('selected', true);

          function cleanArray(arr) {
            var cleanedArr = [];
            for (var i = 0; i < arr.length; i++) {
              if (arr[i] !== ',') {
                cleanedArr.push(arr[i]);
              } else if (i < arr.length - 1 && arr[i + 1] !== ',') {
                cleanedArr.push(arr[i]);
              }
            }
            // If the last element is a comma and there's no text after it, remove it
            if (cleanedArr.length > 0 && cleanedArr[cleanedArr.length - 1] === ',') {
              cleanedArr.pop();
            }
            return cleanedArr;
          }
          $('#dropdownMenuButton').val('');
          let R = data.room.r_facilities;
          let clean = R.split(',');
          let next = cleanArray(clean);
          let newtext = '';
          $('.dropdown-item').removeClass('selected');
          $('.check').css('display', 'none');
          let checkifnull = false;
          $.each(next, function (i, e) {
            let existingItem = $('#dropdown-menu').find('.dropdown-item:contains("' + e.trim() + '")');
            if (existingItem.length !== 0) {
              existingItem.addClass('selected');
              existingItem.find('.check').css('display', 'block');
            }

            if (!$('#dropdownMenuButton').val() && !checkifnull) {
              checkifnull = true;
              newtext += e.trim();
            } else {
              newtext = newtext + ', ' + e.trim();
            }
          });
          $('#dropdownMenuButton').val(newtext);

          $('#dropdownMenuButton1').val('');
          let features = data.room.r_features;
          let clean2 = features.split(',');
          let next2 = cleanArray(clean2);
          let newtext1 = '';
          let checkifnull1 = false;
          $.each(next2, function (i, e) {
            let trimmedValue = e.trim();
            let existingItem = $('#dropdown1').find('.dropdown-item:contains("' + trimmedValue + '")');
            if (existingItem.length !== 0) {
              existingItem.addClass('selected');
              existingItem.find('.check').css('display', 'block');
            }
            if (!$('#dropdownMenuButton1').val() && !checkifnull1) {
              newtext1 = e.trim();
              checkifnull1 = true;
            } else {
              newtext1 = newtext1 + ', ' + e.trim();
            }
          });
          $('#dropdownMenuButton1').val(newtext1);

          $('#r_adult').val(data.room.r_adult);
          $('#r_children').val(data.room.r_children);
          $('#r_description').val(data.room.r_description);
          $('#save_edited_room').val(data.room.r_id);
          $('#room-image').attr('src', '/RoomImg/' + data.room.r_img);
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
      }
    });
  });

  $('#save_edited_room').on('click', function () {
    let id = $(this).val();
    let notNull = true;
    $('#edit-room-form')
      .find('.input')
      .each(function () {
        if (!$(this).val()) {
          warning_msg('Please Fill all Fields.');
          notNull = false;
          return false;
        }
      });
    if (notNull) {
      let editroomform = new FormData($('#edit-room-form')[0]);
      editroomform.append('id', id);
      $.ajax({
        url: 'submit_edit_room',
        method: 'POST',
        data: editroomform,
        contentType: false,
        processData: false,
        dataType: 'json',
        cache: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
          $('#save_edited_room').prop('disabled', true);
          $('#save_edited_room').html('Saving...');
        },
        success: function (data) {
          if (data.message == 'success') {
            success_msg('Room Updated Successfully.');
            // $('.room_tbody').load(roomtable);
            $('#closeeditr').click();
          } else {
            console.log(data);
            error_msg('Failed to update.');
          }
          $('#save_edited_room').prop('disabled', false);
          $('#save_edited_room').html('Save Changes');
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
          error_msg('Opps! Something went wrong.');
          $('#save_edited_room').prop('disabled', false);
          $('#save_edited_room').html('Save Changes');
        }
      });
    }
  });

  $('#save_category').on('click', function () {
    let category_name = $('#category_name').val();
    $.ajax({
      url: 'add_category',
      method: 'POST',
      data: { category_name },
      dataType: 'json',
      cache: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      beforeSend: function () {
        $('#save_category').prop('disabled', true);
        $('#save_category').html('Saving...');
      },
      success: function (data) {
        if (data.message == 'success') {
          success_msg('New Category Added Successfully.');
          $('#category_name').val('');
          $('#close').click();
          $('.tb_category').load(category_tb);
        } else {
          error_msg('Opps! Something went wrong.');
          console.log(data);
        }
        $('#save_category').prop('disabled', false);
        $('#save_category').html('Save');
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        $('#save_category').prop('disabled', false);
        $('#save_category').html('Save');
      }
    });
    return false;
  });

  $('#table_body').on('click', '.delete-category-btn', function () {
    let id = $(this).val();
    Swal.fire({
      title: 'Are you sure?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Delete!'
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'delete_category',
          method: 'POST',
          data: { id },
          dataType: 'json',
          cache: false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (data) {
            if (data.message == 'success') {
              success_msg('Category Deleted Successfully.');
              $('.row' + data.id).hide();
            } else {
              error_msg('Failed to Delete.');
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

  $('#table_body').on('click', '.update-category-btn', function () {
    let id = $(this).val();
    $.ajax({
      url: 'show_category',
      method: 'POST',
      data: { id },
      dataType: 'json',
      cache: false,
      headers: {
        X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (data) {
        if (data.message == 'success') {
          $('#edit_category_name').val(data.category.Name);
          $('#id_hidden').val(data.category.id);
        } else {
          error_msg('Opps! Something went wrong.');
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
      }
    });
  });

  $('#save_edit_category').on('click', function () {
    let id = $('#id_hidden').val();
    let name = $('#edit_category_name').val();

    $.ajax({
      url: 'save_edited_category',
      method: 'POST',
      data: {
        id: id,
        name: name
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'json',
      cache: false,
      beforeSend: function () {
        $('#save_edit_category').prop('disabled', true);
        $('#save_edit_category').html('Saving..');
      },
      success: function (data) {
        if (data.message == 'success') {
          $('#eclose').click();
          $('.tb_category').load(category_tb);
          success_msg('Category Updated Successfully.');
        } else {
          console.log(data);
          error_msg('Opps! Something went wrong.');
        }
        $('#save_edit_category').prop('disabled', false);
        $('#save_edit_category').html('Save');
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
      }
    });
  });

  // Add New Facility
  $('#save_facility').on('click', function () {
    let facility_n = $('#facility_name').val();
    $.ajax({
      url: 'add_facility',
      method: 'POST',
      data: { facility_n },
      cache: false,
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      beforeSend: function () {
        $('#save_facility').prop('disabled', true);
        $('#save_facility').html('Saving..');
      },
      success: function (data) {
        if (data.message == 'success') {
          $('#fclose').click();
          $('#facility_name').val('');
          success_msg('Facility Added Successfully.');
          $('.tb_facility').load(facilitytb);
        } else {
          error_msg('Opps! Something went wrong.');
          console.log(data);
        }
        $('#save_facility').prop('disabled', false);
        $('#save_facility').html('Save');
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
      }
    });
  });
  // delete facility
  $('.tb_facility').on('click', '.delete-facility-btn', function () {
    let id = $(this).val();
    Swal.fire({
      title: 'Are you sure?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Delete!'
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'delete_facility',
          method: 'POST',
          data: { id },
          dataType: 'json',
          cache: false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (data) {
            if (data.message == 'success') {
              success_msg('Facility Deleted Succcessfully.');
              $('.row' + data.id).hide();
            } else {
              console.log(data);
              error_msg('Opps! Something went wrong.');
            }
          },
          error: function (xhr, status, error) {
            console.log(xhr.responseText);
          }
        });
      }
    });
  });

  // update facility
  $('.tb_facility').on('click', '.update-facility-btn', function () {
    let id = $(this).val();
    $.ajax({
      url: 'show_facility',
      method: 'POST',
      data: { id },
      dataType: 'json',
      cache: false,
      headers: {
        X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (data) {
        if (data.message == 'success') {
          $('#id_hidden').val(data.facility.id);
          $('#edit_facility_name').val(data.facility.name);
        } else {
          error_msg('Opps! Something went wrong.');
          console.log(data);
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
      }
    });
  });

  $('#save_edit_facility').on('click', function () {
    let id = $('#id_hidden').val();
    let name = $('#edit_facility_name').val();
    $.ajax({
      url: 'update_facility',
      method: 'POST',
      data: {
        id: id,
        name: name
      },
      dataType: 'json',
      cache: false,
      headers: {
        X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
      },
      beforeSend: function () {
        $('#save_edit_facility').prop('disabled', true);
        $('#save_edit_facility').html('Saving...');
      },
      success: function (data) {
        if (data.message == 'success') {
          success_msg('Facility Updated Successfully.');
          $('#facilityclose').click();
          $('.tb_facility').load(facilitytb);
        } else {
          console.log(data);
          error_msg('Opps! SOmething went wrong.');
        }
        $('#save_edit_facility').prop('disabled', false);
        $('#save_edit_facility').html('Save');
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
      }
    });
  });

  $('#save_feature').on('click', function () {
    let name = $('#feature_name').val();

    $.ajax({
      url: 'add_feature',
      method: 'POST',
      data: { name },
      dataType: 'json',
      cache: false,
      headers: {
        X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
      },
      beforeSend: function () {
        $('#save_feature').prop('disabled', true);
        $('#save_feature').html('Saving...');
      },
      success: function (data) {
        if (data.message == 'success') {
          success_msg('New Feature Added Successfully.');
          $('#fclose').click();
          $('.tb_feature').load(featuretable);
          $('#feature_name').val('');
        } else {
          error_msg('Opps! Something went wrong.');
          console.log(data);
        }
        $('#save_feature').prop('disabled', false);
        $('#save_feature').html('Save');
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
      }
    });
  });

  $('.tb_feature').on('click', '.delete-feature-btn', function () {
    let id = $(this).val();
    Swal.fire({
      title: 'Are you sure?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Delete!'
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'dealte_feature',
          method: 'POST',
          data: { id },
          dataType: 'json',
          cahce: false,
          headers: {
            X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
          },
          success: function (data) {
            if (data.message == 'success') {
              success_msg('Feature Deleted Successfully.');
              $('.row' + data.id).hide();
            } else {
              error_msg('Failed to delete.');
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

  $('.tb_feature').on('click', '.update-feature-btn', function () {
    let id = $(this).val();
    $.ajax({
      url: 'view_feature',
      method: 'POST',
      data: { id },
      dataType: 'json',
      cahce: false,
      headers: {
        X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (data) {
        if (data.message == 'success') {
          $('#edit_feature_name').val(data.feature.name);
          $('#id_hidden').val(data.feature.id);
        } else {
          error_msg('Something went wrong.');
          console.log(data);
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
      }
    });
  });

  $('#save_edit_feature').on('click', function () {
    let name = $('#edit_feature_name').val();
    let id = $('#id_hidden').val();
    $.ajax({
      url: 'update_feature',
      method: 'POST',
      data: {
        name: name,
        id: id
      },
      dataType: 'json',
      cache: false,
      headers: {
        X_CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
      },
      beforeSend: function () {
        $('#save_edit_feature').prop('disabled', true);
        $('#save_edit_feature').html('Saving...');
      },
      success: function (data) {
        if (data.message == 'success') {
          success_msg('Feature Updated Successfully.');
          $('#fetclose').click();
          $('.tb_feature').load(featuretable);
        } else {
          error_msg('Opps! Something went wrong.');
          console.log(data);
        }
        $('#save_edit_feature').prop('disabled', false);
        $('#save_edit_feature').html('Save');
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
      }
    });
  });
});
