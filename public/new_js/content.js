$('.browse').click(function () {
  $('#uploadImg').click();
});
$('.custom-file').on('change', '#uploadImg', function () {
  var file = this.files[0];
  $('#img').val(file.name);
  $('#img').attr('hidden', false);
});
