$(document).ready(function () {
  $('.browse').click(function () {
    $('#uploadImg').click();
  });
  $('#uploadImg').change(function () {
    var file = this.files[0];
    $('#img').val(file.name);
    $('#img').removeAttr('hidden');
  });
});
