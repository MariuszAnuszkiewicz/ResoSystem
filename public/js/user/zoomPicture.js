$(document).ready(function() {
  $('.zoom').on('click', function(){
      $(this).toggleClass('zoomed');
      if ($(this).hasClass('zoomed')) {
          $(this).addClass("little-lupe");
          $(this).find(".lupe-icon").removeClass( "plus" );
          $(this).find(".lupe-icon").addClass( "minus" );
          $(this).parents(".book-img").addClass('zoomed');
          $(this).parents(".book-img").css({'z-index': 10});
      } else {
          $(this).removeClass("little-lupe");
          $(this).find(".lupe-icon").removeClass("minus");
          $(this).find(".lupe-icon").toggleClass( "plus" );
          $(this).parents(".book-img").removeClass('zoomed');
          $(this).parents(".book-img").css({'z-index': 0});
      }
  });
});