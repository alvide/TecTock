document.addEventListener("DOMContentLoaded", function() {
    window.onscroll = function() {  // Mostra o nascondi il link "Torna su" in base allo scroll della pagina
        scrollFunction();
    };

    function scrollFunction() {
        var scrollToTopLink = document.getElementById("scrollToTopLink");
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            scrollToTopLink.style.display = (window.innerWidth > 600) ? "inline-block" : "none"; // Mostra il link solo se la larghezza dello schermo è maggiore di 600px   
        } else {
            scrollToTopLink.style.display = "none";
        }
    }

    // Torna su quando il link viene cliccato
    var scrollToTopLink = document.getElementById("scrollToTopLink");
    if (scrollToTopLink) {
        scrollToTopLink.addEventListener("click", function(event) {
            event.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    }
});


