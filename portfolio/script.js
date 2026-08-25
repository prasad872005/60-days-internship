/* =========================
   PORTFOLIO JAVASCRIPT
========================= */


/* =========================
   1. VARIABLES
========================= */

const menuToggle = document.getElementById("menuToggle");
const navLinks = document.getElementById("navLinks");

const contactForm = document.getElementById("contactForm");

const nameInput = document.getElementById("name");
const emailInput = document.getElementById("email");
const messageInput = document.getElementById("message");

const formMessage = document.getElementById("formMessage");


/* =========================
   2. ARRAY
========================= */

const skills = [
    "HTML5",
    "CSS3",
    "JavaScript",
    "React.js",
    "Node.js",
    "Express.js",
    "MongoDB",
    "MySQL",
    "Git & GitHub"
];

console.log("My Skills:", skills);


/* =========================
   3. FUNCTION
========================= */

function showWelcomeMessage() {
    console.log("Welcome to Prasad's Portfolio!");
}


/* =========================
   4. CLICK EVENT
   Mobile Menu
========================= */

menuToggle.addEventListener("click", function () {

    navLinks.classList.toggle("active");

});


/* =========================
   5. NAVIGATION CLICK EVENT
   Close mobile menu
========================= */

const navigationLinks = document.querySelectorAll(".nav-links a");

navigationLinks.forEach(function (link) {

    link.addEventListener("click", function () {

        navLinks.classList.remove("active");

    });

});


/* =========================
   6. KEYUP EVENT
   Name input
========================= */

nameInput.addEventListener("keyup", function () {

    const name = nameInput.value.trim();

    if (name.length > 0) {

        nameInput.style.borderColor = "green";

    } else {

        nameInput.style.borderColor = "";

    }

});


/* =========================
   7. CHANGE EVENT
   Email input
========================= */

emailInput.addEventListener("change", function () {

    const email = emailInput.value.trim();

    const emailPattern =
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (emailPattern.test(email)) {

        emailInput.style.borderColor = "green";

    } else {

        emailInput.style.borderColor = "red";

    }

});


/* =========================
   8. FORM VALIDATION
========================= */

contactForm.addEventListener("submit", function (event) {

    event.preventDefault();


    // Get values

    const name = nameInput.value.trim();
    const email = emailInput.value.trim();
    const message = messageInput.value.trim();


    // Error elements

    const nameError = document.getElementById("nameError");
    const emailError = document.getElementById("emailError");
    const messageError = document.getElementById("messageError");


    // Clear previous errors

    nameError.textContent = "";
    emailError.textContent = "";
    messageError.textContent = "";

    formMessage.textContent = "";


    let isValid = true;


    /* =========================
       NAME VALIDATION
    ========================= */

    if (name === "") {

        nameError.textContent =
            "Please enter your name.";

        isValid = false;

    }


    /* =========================
       EMAIL VALIDATION
    ========================= */

    const emailPattern =
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email === "") {

        emailError.textContent =
            "Please enter your email.";

        isValid = false;

    } else if (!emailPattern.test(email)) {

        emailError.textContent =
            "Please enter a valid email address.";

        isValid = false;

    }


    /* =========================
       MESSAGE VALIDATION
    ========================= */

    if (message === "") {

        messageError.textContent =
            "Please enter your message.";

        isValid = false;

    } else if (message.length < 10) {

        messageError.textContent =
            "Message must contain at least 10 characters.";

        isValid = false;

    }


    /* =========================
       SUCCESS
    ========================= */

    if (isValid) {

        formMessage.textContent =
            "Thank you! Your message has been submitted successfully.";

        formMessage.style.color = "green";

        contactForm.reset();

        nameInput.style.borderColor = "";
        emailInput.style.borderColor = "";

    }

});


/* =========================
   START FUNCTION
========================= */

showWelcomeMessage();