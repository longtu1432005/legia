$('.carousel').carousel({
    interval: 5000 //changes the speed
});

$(document).ready(function(){

    //Check to see if the window is top if not then display button
    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('.scrollToTop').fadeIn();
        } else {
            $('.scrollToTop').fadeOut();
        }
    });

    //Click event to scroll to top
    $('.scrollToTop').click(function(){
        $('html, body').animate({scrollTop : 0},800);
        return false;
    });

    $('.blog-container img').each(function (item) {
        $(this).attr('width', 'auto');
        $(this).addClass('img-responsive');
    });

});