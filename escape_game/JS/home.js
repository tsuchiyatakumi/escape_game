$(function() {
  $(".top").on("click", function() {
    $(this).children(".down").slideToggle();
  });
});
