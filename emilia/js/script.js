function smoothScroll(element) {
    document.querySelector(element).scrollIntoView({
        behavior: "smooth"

    });
}

function reserve(narzedzia) {
    var select = document.getElementById('narzedzia');
    var options_selected = select.querySelectorAll('option[selected]');


    options_selected.forEach(function (option) {
        option.removeAttribute("selected");
    });


    var option = select.querySelector('option[value="'+narzedzia+'"]');

    option.setAttribute("selected","selected");
    smoothScroll('#reservation');
}