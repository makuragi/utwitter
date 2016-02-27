$(function(){
    $(".post-form").focus(function(){
      $(this).attr('rows', 4);
    }).blur(function(){
        $(this).attr('rows', 1);
    });
});