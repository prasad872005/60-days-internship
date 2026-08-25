/* =========================
   PORTFOLIO JAVASCRIPT
========================= */


/* =========================
   1. VARIABLES
========================= */

const contactForm = document.querySelector("#contact form");

const nameInput = document.getElementById("name");
const emailInput = document.getElementById("email");
const phoneInput = document.getElementById("phone");
const subjectInput = document.getElementById("subject");
const messageInput = document.getElementById("message");


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
   4. KEYUP EVENT
   Name validation
========================= */

nameInput.addEventListener("keyup", function () {

    const name = nameInput.value.trim();

    const namePattern = /^[A-Za-z ]+$/;

    if (name.length >= 3 && namePattern.test(name)) {
        nameInput.style.borderColor = "green";
    } else {
        nameInput.style.borderColor = "red";
    }

});


/* =========================
   5. CHANGE EVENT
   Email validation
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
   6. PHONE VALIDATION
========================= */

phoneInput.addEventListener("input", function () {

    const phone = phoneInput.value.trim();

    const phonePattern = /^[6-9][0-9]{9}$/;

    if (phonePattern.test(phone)) {
        phoneInput.style.borderColor = "green";
    } else {
        phoneInput.style.borderColor = "red";
    }

});


/* =========================
   7. FORM SUBMIT EVENT
========================= */

contactForm.addEventListener("submit", function (event) {

    event.preventDefault();


    const name = nameInput.value.trim();
    const email = emailInput.value.trim();
    const phone = phoneInput.value.trim();
    const subject = subjectInput.value.trim();
    const message = messageInput.value.trim();


    const namePattern = /^[A-Za-z ]+$/;

    const emailPattern =
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    const phonePattern =
        /^[6-9][0-9]{9}$/;


    let isValid = true;


    /* =========================
       NAME VALIDATION
    ========================= */

    if (name === "") {

        alert("Please enter your name.");
        isValid = false;

    } else if (name.length < 3) {

        alert("Name must contain at least 3 characters.");
        isValid = false;

    } else if (!namePattern.test(name)) {

        alert("Name should contain only letters and spaces.");
        isValid = false;

    }


    /* =========================
       EMAIL VALIDATION
    ========================= */

    if (isValid && !emailPattern.test(email)) {

        alert("Please enter a valid email address.");
        isValid = false;

    }


    /* =========================
       PHONE VALIDATION
    ========================= */

    if (isValid && !phonePattern.test(phone)) {

        alert("Please enter a valid 10-digit Indian mobile number.");
        isValid = false;

    }


    /* =========================
       SUBJECT VALIDATION
    ========================= */

    if (isValid && subject.length < 3) {

        alert("Subject must contain at least 3 characters.");
        isValid = false;

    }


    /* =========================
       MESSAGE VALIDATION
    ========================= */

    if (isValid && message.length < 10) {

        alert("Message must contain at least 10 characters.");
        isValid = false;

    }


    /* =========================
       SUCCESS
    ========================= */

    if (isValid) {

        alert(
            "Thank you, " +
            name +
            "! Your message has been submitted successfully."
        );

        contactForm.reset();

        nameInput.style.borderColor = "";
        emailInput.style.borderColor = "";
        phoneInput.style.borderColor = "";

    }

});


/* =========================
   START
========================= */

showWelcomeMessage();