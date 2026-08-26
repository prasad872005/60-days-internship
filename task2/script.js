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

/* =========================
   LOGIN PAGE
========================= */


/* =========================
   LOGIN VARIABLES
========================= */

const loginForm =
    document.getElementById("loginForm");

const loginEmail =
    document.getElementById("loginEmail");

const loginPassword =
    document.getElementById("loginPassword");

const toggleLoginPassword =
    document.getElementById("toggleLoginPassword");

const loginPasswordIcon =
    document.getElementById("loginPasswordIcon");

const loginEmailError =
    document.getElementById("loginEmailError");

const loginPasswordError =
    document.getElementById("loginPasswordError");

const loginMessage =
    document.getElementById("loginMessage");


/* =========================
   SHOW / HIDE PASSWORD
========================= */

if (toggleLoginPassword) {

    toggleLoginPassword.addEventListener(
        "click",
        function () {

            if (loginPassword.type === "password") {

                loginPassword.type = "text";

                loginPasswordIcon.classList.remove(
                    "bi-eye"
                );

                loginPasswordIcon.classList.add(
                    "bi-eye-slash"
                );

            } else {

                loginPassword.type = "password";

                loginPasswordIcon.classList.remove(
                    "bi-eye-slash"
                );

                loginPasswordIcon.classList.add(
                    "bi-eye"
                );

            }

        }
    );

}


/* =========================
   LOGIN FORM VALIDATION
========================= */

if (loginForm) {

    loginForm.addEventListener(
        "submit",
        function (event) {

            event.preventDefault();


            /* Clear messages */

            loginEmailError.textContent = "";

            loginPasswordError.textContent = "";

            loginMessage.textContent = "";


            let isValid = true;


            /* =========================
               EMAIL
            ========================== */

            const email =
                loginEmail.value.trim();

            const emailPattern =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


            if (email === "") {

                loginEmailError.textContent =
                    "Please enter your email.";

                isValid = false;

            } else if (
                !emailPattern.test(email)
            ) {

                loginEmailError.textContent =
                    "Please enter a valid email address.";

                isValid = false;

            }


            /* =========================
               PASSWORD
            ========================== */

            const password =
                loginPassword.value;


            if (password === "") {

                loginPasswordError.textContent =
                    "Please enter your password.";

                isValid = false;

            } else if (password.length < 6) {

                loginPasswordError.textContent =
                    "Password must contain at least 6 characters.";

                isValid = false;

            }


            /* =========================
               SUCCESS
            ========================== */

            if (isValid) {

                loginMessage.textContent =
                    "Login successful!";

                loginMessage.style.color =
                    "green";

                console.log(
                    "Login submitted:",
                    email
                );

            }

        }
    );

}