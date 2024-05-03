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

          let facility = $('<option>', {
            value: data.room.r_facilities,
            text: data.room.r_facilities,
            'data-dynamic': 'true'
          });

          // let R = data.room.r_facilities;
          // let R_rey = R.split(',');
          // R_rey.forEach(function (value) {
          //   //
          // });

          $('#r_facilities').append(facility);
          facility.prop('selected', true);

          let feature = $('<option>', {
            value: data.room.r_features,
            text: data.room.r_features,
            'data-dynamic': 'true'
          });

          $('#r_features').append(feature);
          feature.prop('selected', true);

          $('#r_adult').val(data.room.r_adult);
          $('#r_children').val(data.room.r_children);
          $('#r_description').val(data.room.r_description);
          $('#room-image').attr('src', '/RoomImg/' + data.room.r_img);
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
      }
    });
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
});
