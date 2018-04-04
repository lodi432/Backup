$(document).foundation()


$(".rotate").click(function(){
    $(this).toggleClass("down");
});


$('[data-app-dashboard-toggle-shrink]').on('click', function(e) {
  e.preventDefault();
  $(this).parents('.app-dashboard').toggleClass('shrink-medium').toggleClass('shrink-large');
});
