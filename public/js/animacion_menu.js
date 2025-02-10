document.addEventListener("DOMContentLoaded", function () {
    let lastScrollY = window.scrollY;
    const header = document.querySelector("header");
    const nav = document.querySelector("nav");

    window.addEventListener("scroll", () => {
        if (window.scrollY > lastScrollY) {
            // Desplazamiento hacia abajo: ocultar encabezado y menú
            header.style.transform = "translateY(-100%)";
            nav.style.transform = "translateY(-100%)";
        } else {
            // Desplazamiento hacia arriba: mostrar encabezado y menú
            header.style.transform = "translateY(0)";
            nav.style.transform = "translateY(0)";
        }
        lastScrollY = window.scrollY;
    });
});