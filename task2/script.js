/* =========================
   TASK 2 JAVASCRIPT
========================= */


/* =========================
   1. VARIABLES
========================= */

const welcomeModal =
    document.getElementById("welcomeModal");


/* =========================
   2. ARRAY
========================= */

const technologies = [
    "HTML5",
    "CSS3",
    "JavaScript",
    "Bootstrap 5",
    "Fetch API"
];

console.log("Technologies:", technologies);


/* =========================
   3. FUNCTION
========================= */

function showWelcome() {

    console.log(
        "Welcome to AuthUI - Task 2!"
    );

}


/* =========================
   4. PAGE LOAD EVENT
========================= */

window.addEventListener("load", function () {

    showWelcome();

});


/* =========================
   5. NAVBAR SMOOTH SCROLL
========================= */

const navLinks =
    document.querySelectorAll(
        ".navbar a[href^='#']"
    );


navLinks.forEach(function (link) {

    link.addEventListener("click", function () {

        const targetId =
            link.getAttribute("href");

        const target =
            document.querySelector(targetId);

        if (target) {

            target.scrollIntoView({
                behavior: "smooth"
            });

        }

    });

});