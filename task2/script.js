/* =====================================================
   TASK 2 - INTERACTIVE UI & FRONTEND DEVELOPMENT
   JavaScript
===================================================== */


/* =====================================================
   1. VARIABLES
===================================================== */

const registerForm = document.getElementById("registerForm");

const registerName = document.getElementById("registerName");
const registerEmail = document.getElementById("registerEmail");
const registerPassword = document.getElementById("registerPassword");
const confirmPassword = document.getElementById("confirmPassword");

const toggleRegisterPassword =
    document.getElementById("toggleRegisterPassword");

const toggleConfirmPassword =
    document.getElementById("toggleConfirmPassword");

const registerSuccess =
    document.getElementById("registerSuccess");


/* =====================================================
   2. ARRAY
===================================================== */

const technologies = [
    "HTML5",
    "CSS3",
    "JavaScript",
    "Bootstrap 5",
    "React.js",
    "Node.js",
    "Express.js",
    "MongoDB",
    "MySQL"
];

console.log("Technologies used in Task 2:", technologies);


/* =====================================================
   3. FUNCTION
===================================================== */

function showWelcomeMessage() {

    console.log(
        "Welcome to Task 2 - Interactive UI & Frontend Development!"
    );

}

showWelcomeMessage();


/* =====================================================
   4. SHOW / HIDE PASSWORD
===================================================== */


/* Register Password */

if (toggleRegisterPassword) {

    toggleRegisterPassword.addEventListener("click", function () {

        if (registerPassword.type === "password") {

            registerPassword.type = "text";

            toggleRegisterPassword.innerHTML =
                '<i class="bi bi-eye-slash"></i>';

        } else {

            registerPassword.type = "password";

            toggleRegisterPassword.innerHTML =
                '<i class="bi bi-eye"></i>';

        }

    });

}


/* Confirm Password */

if (toggleConfirmPassword) {

    toggleConfirmPassword.addEventListener("click", function () {

        if (confirmPassword.type === "password") {

            confirmPassword.type = "text";

            toggleConfirmPassword.innerHTML =
                '<i class="bi bi-eye-slash"></i>';

        } else {

            confirmPassword.type = "password";

            toggleConfirmPassword.innerHTML =
                '<i class="bi bi-eye"></i>';

        }

    });

}


/* =====================================================
   5. NAME VALIDATION - KEYUP EVENT
===================================================== */

if (registerName) {

    registerName.addEventListener("keyup", function () {

        const name = registerName.value.trim();

        const namePattern = /^[A-Za-z ]+$/;

        if (
            name.length >= 3 &&
            namePattern.test(name)
        ) {

            registerName.classList.remove("is-invalid");

            registerName.classList.add("is-valid");

        } else {

            registerName.classList.remove("is-valid");

            registerName.classList.add("is-invalid");

        }

    });

}


/* =====================================================
   6. EMAIL VALIDATION - CHANGE EVENT
===================================================== */

if (registerEmail) {

    registerEmail.addEventListener("change", function () {

        const email = registerEmail.value.trim();

        const emailPattern =
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (emailPattern.test(email)) {

            registerEmail.classList.remove("is-invalid");

            registerEmail.classList.add("is-valid");

        } else {

            registerEmail.classList.remove("is-valid");

            registerEmail.classList.add("is-invalid");

        }

    });

}


/* =====================================================
   7. PASSWORD VALIDATION
===================================================== */

if (registerPassword) {

    registerPassword.addEventListener("keyup", function () {

        const password =
            registerPassword.value;

        if (password.length >= 6) {

            registerPassword.classList.remove("is-invalid");

            registerPassword.classList.add("is-valid");

        } else {

            registerPassword.classList.remove("is-valid");

            registerPassword.classList.add("is-invalid");

        }

    });

}


/* =====================================================
   8. PASSWORD MATCH CHECK
===================================================== */

if (confirmPassword) {

    confirmPassword.addEventListener("keyup", function () {

        const password =
            registerPassword.value;

        const confirm =
            confirmPassword.value;

        if (
            confirm.length > 0 &&
            password === confirm
        ) {

            confirmPassword.classList.remove("is-invalid");

            confirmPassword.classList.add("is-valid");

        } else {

            confirmPassword.classList.remove("is-valid");

            confirmPassword.classList.add("is-invalid");

        }

    });

}


/* =====================================================
   9. DUMMY AJAX FUNCTION
   Simulates checking email availability
===================================================== */

function checkEmailExists(email) {

    return new Promise(function (resolve) {

        setTimeout(function () {

            /*
               Dummy existing email.
               This simulates a PHP/AJAX response.
            */

            const existingEmail =
                "test@gmail.com";

            if (email.toLowerCase() === existingEmail) {

                resolve(true);

            } else {

                resolve(false);

            }

        }, 800);

    });

}


/* =====================================================
   10. REGISTRATION FORM SUBMIT
===================================================== */

if (registerForm) {

    registerForm.addEventListener(
        "submit",
        async function (event) {

            event.preventDefault();


            /* Get values */

            const name =
                registerName.value.trim();

            const email =
                registerEmail.value.trim();

            const password =
                registerPassword.value;

            const confirm =
                confirmPassword.value;


            /* Patterns */

            const namePattern =
                /^[A-Za-z ]+$/;

            const emailPattern =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


            /* Clear success message */

            registerSuccess.textContent = "";

            registerSuccess.className =
                "success-message mt-3";


            /* Validation */

            if (name === "") {

                alert("Please enter your full name.");

                registerName.focus();

                return;

            }


            if (
                name.length < 3 ||
                !namePattern.test(name)
            ) {

                alert(
                    "Name should contain at least 3 letters and only letters and spaces."
                );

                registerName.focus();

                return;

            }


            if (
                email === "" ||
                !emailPattern.test(email)
            ) {

                alert(
                    "Please enter a valid email address."
                );

                registerEmail.focus();

                return;

            }


            if (password.length < 6) {

                alert(
                    "Password must contain at least 6 characters."
                );

                registerPassword.focus();

                return;

            }


            if (password !== confirm) {

                alert(
                    "Passwords do not match."
                );

                confirmPassword.focus();

                return;

            }


            const terms =
                document.getElementById("terms");


            if (!terms.checked) {

                alert(
                    "Please accept the Terms and Conditions."
                );

                return;

            }


            /* =================================================
               DUMMY AJAX EMAIL CHECK
            ================================================= */

            registerSuccess.textContent =
                "Checking email availability...";

            registerSuccess.classList.add(
                "text-primary"
            );


            const emailExists =
                await checkEmailExists(email);


            if (emailExists) {

                registerSuccess.textContent =
                    "This email is already registered.";

                registerSuccess.classList.remove(
                    "text-primary"
                );

                registerSuccess.classList.add(
                    "text-danger"
                );

                return;

            }


            /* =================================================
               SUCCESS
            ================================================= */

            registerSuccess.textContent =
                "Registration successful! Welcome, " +
                name +
                ".";

            registerSuccess.classList.remove(
                "text-primary"
            );

            registerSuccess.classList.add(
                "text-success"
            );


            alert(
                "Registration successful! Welcome, " +
                name +
                "!"
            );


            registerForm.reset();


            /* Remove validation classes */

            registerName.classList.remove(
                "is-valid",
                "is-invalid"
            );

            registerEmail.classList.remove(
                "is-valid",
                "is-invalid"
            );

            registerPassword.classList.remove(
                "is-valid",
                "is-invalid"
            );

            confirmPassword.classList.remove(
                "is-valid",
                "is-invalid"
            );

        }
    );

}


/* =====================================================
   11. BUTTON HOVER LOG
===================================================== */

const buttons =
    document.querySelectorAll(".btn");

buttons.forEach(function (button) {

    button.addEventListener("mouseenter", function () {

        console.log(
            "Mouse entered button:",
            button.textContent.trim()
        );

    });

});


/* =====================================================
   12. PAGE LOAD EVENT
===================================================== */

window.addEventListener("load", function () {

    console.log(
        "Task 2 page loaded successfully."
    );

});