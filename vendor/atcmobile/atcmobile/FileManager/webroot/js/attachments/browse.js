$(function() {
  $('.selector').on('click', function (e) {
    e.preventDefault();
    var slug = $(this).data('slug');

    Atcmobapp.Wysiwyg.choose(slug);
  });
});
