$(document).ready(function () {
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll > 50) {
            $(".nav-link").attr("style", "color: var(--black)");
            $(".navbar").addClass("scrolled");
            $("#logo_navbar").html(
                '<img src="assets/pembeli/img/logonavbar_hitam.png" alt="" width="100%" height="50px">'
            );
        } else {
            $(".navbar").removeClass("scrolled");
            $(".nav-link").removeAttr("style");
            $("#logo_navbar").html(
                '<img src="assets/pembeli/img/logonavbar_putih.png" alt="" width="100%" height="50px">'
            );
        }
    });
});
