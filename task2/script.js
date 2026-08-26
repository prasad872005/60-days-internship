/* =====================================================
   TASK 2 - INTERACTIVE UI & FRONTEND DEVELOPMENT
   JavaScript
===================================================== */


/* =====================================================
   1. REGISTRATION VARIABLES
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
   2. LOGIN VARIABLES
===================================================== */

const loginForm = document.getElementById("loginForm");

const loginEmail = document.getElementById("loginEmail");
const loginPassword = document.getElementById("loginPassword");

const toggleLoginPassword =
    document.getElementById("toggleLoginPassword");

const loginEyeIcon =
    document.getElementById("loginEyeIcon");

const loginEmailError =
    document.getElementById("loginEmailError");

const loginPasswordError =
    document.getElementById("loginPasswordError");

const loginSuccess =
    document.getElementById("loginSuccess");

const rememberMe =
    document.getElementById("rememberMe");


/* =====================================================
   3. ARRAY
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

console.log(
    "Technologies used in Task 2:",
    technologies
);


/* =====================================================
   4. FUNCTION
===================================================== */

function showWelcomeMessage() {

    console.log(
        "Welcome to Task 2 - Interactive UI & Frontend Development!"
    );

}

showWelcomeMessage();


/* =====================================================
   5. SHOW / HIDE REGISTER PASSWORD
===================================================== */


/* Register Password */

if (
    toggleRegisterPassword &&
    registerPassword
) {

    toggleRegisterPassword.addEventListener(
        "click",
        function () {

            if (registerPassword.type === "password") {

                registerPassword.type = "text";

                toggleRegisterPassword.innerHTML =
                    '<i class="bi bi-eye-slash"></i>';

            } else {

                registerPassword.type = "password";

                toggleRegisterPassword.innerHTML =
                    '<i class="bi bi-eye"></i>';

            }

        }
    );

}


/* =====================================================
   6. SHOW / HIDE CONFIRM PASSWORD
===================================================== */

if (
    toggleConfirmPassword &&
    confirmPassword
) {

    toggleConfirmPassword.addEventListener(
        "click",
        function () {

            if (confirmPassword.type === "password") {

                confirmPassword.type = "text";

                toggleConfirmPassword.innerHTML =
                    '<i class="bi bi-eye-slash"></i>';

            } else {

                confirmPassword.type = "password";

                toggleConfirmPassword.innerHTML =
                    '<i class="bi bi-eye"></i>';

            }

        }
    );

}


/* =====================================================
   7. SHOW / HIDE LOGIN PASSWORD
===================================================== */

if (
    toggleLoginPassword &&
    loginPassword
) {

    toggleLoginPassword.addEventListener(
        "click",
        function () {

            if (loginPassword.type === "password") {

                loginPassword.type = "text";

                if (loginEyeIcon) {

                    loginEyeIcon.className =
                        "bi bi-eye-slash";

                }

                toggleLoginPassword.setAttribute(
                    "aria-label",
                    "Hide password"
                );

            } else {

                loginPassword.type = "password";

                if (loginEyeIcon) {

                    loginEyeIcon.className =
                        "bi bi-eye";

                }

                toggleLoginPassword.setAttribute(
                    "aria-label",
                    "Show password"
                );

            }

        }
    );

}


/* =====================================================
   8. REGISTER NAME VALIDATION
   KEYUP EVENT
===================================================== */

if (registerName) {

    registerName.addEventListener(
        "keyup",
        function () {

            const name =
                registerName.value.trim();

            const namePattern =
                /^[A-Za-z ]+$/;


            if (
                name.length >= 3 &&
                namePattern.test(name)
            ) {

                registerName.classList.remove(
                    "is-invalid"
                );

                registerName.classList.add(
                    "is-valid"
                );

            } else {

                registerName.classList.remove(
                    "is-valid"
                );

                registerName.classList.add(
                    "is-invalid"
                );

            }

        }
    );

}


/* =====================================================
   9. REGISTER EMAIL VALIDATION
   CHANGE EVENT
===================================================== */

if (registerEmail) {

    registerEmail.addEventListener(
        "change",
        function () {

            const email =
                registerEmail.value.trim();

            const emailPattern =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


            if (emailPattern.test(email)) {

                registerEmail.classList.remove(
                    "is-invalid"
                );

                registerEmail.classList.add(
                    "is-valid"
                );

            } else {

                registerEmail.classList.remove(
                    "is-valid"
                );

                registerEmail.classList.add(
                    "is-invalid"
                );

            }

        }
    );

}


/* =====================================================
   10. REGISTER PASSWORD VALIDATION
===================================================== */

if (registerPassword) {

    registerPassword.addEventListener(
        "keyup",
        function () {

            const password =
                registerPassword.value;


            if (password.length >= 6) {

                registerPassword.classList.remove(
                    "is-invalid"
                );

                registerPassword.classList.add(
                    "is-valid"
                );

            } else {

                registerPassword.classList.remove(
                    "is-valid"
                );

                registerPassword.classList.add(
                    "is-invalid"
                );

            }

        }
    );

}


/* =====================================================
   11. CONFIRM PASSWORD MATCH CHECK
===================================================== */

if (confirmPassword) {

    confirmPassword.addEventListener(
        "keyup",
        function () {

            const password =
                registerPassword.value;

            const confirm =
                confirmPassword.value;


            if (
                confirm.length > 0 &&
                password === confirm
            ) {

                confirmPassword.classList.remove(
                    "is-invalid"
                );

                confirmPassword.classList.add(
                    "is-valid"
                );

            } else {

                confirmPassword.classList.remove(
                    "is-valid"
                );

                confirmPassword.classList.add(
                    "is-invalid"
                );

            }

        }
    );

}


/* =====================================================
   12. DUMMY AJAX FUNCTION
   SIMULATES PHP EMAIL CHECK
===================================================== */

function checkEmailExists(email) {

    return new Promise(
        function (resolve) {

            setTimeout(
                function () {

                    /*
                       Dummy existing email.
                       This simulates an AJAX/PHP response.
                    */

                    const existingEmail =
                        "test@gmail.com";


                    if (
                        email.toLowerCase() ===
                        existingEmail
                    ) {

                        resolve(true);

                    } else {

                        resolve(false);

                    }

                },
                800
            );

        }
    );

}


/* =====================================================
   13. REGISTRATION FORM SUBMIT
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


            /* Clear previous message */

            if (registerSuccess) {

                registerSuccess.textContent = "";

                registerSuccess.className =
                    "success-message mt-3";

            }


            /* Name validation */

            if (name === "") {

                alert(
                    "Please enter your full name."
                );

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


            /* Email validation */

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


            /* Password validation */

            if (password.length < 6) {

                alert(
                    "Password must contain at least 6 characters."
                );

                registerPassword.focus();

                return;

            }


            /* Confirm password */

            if (password !== confirm) {

                alert(
                    "Passwords do not match."
                );

                confirmPassword.focus();

                return;

            }


            /* Terms */

            const terms =
                document.getElementById("terms");


            if (terms && !terms.checked) {

                alert(
                    "Please accept the Terms and Conditions."
                );

                return;

            }


            /* Dummy AJAX */

            if (registerSuccess) {

                registerSuccess.textContent =
                    "Checking email availability...";

                registerSuccess.classList.add(
                    "text-primary"
                );

            }


            const emailExists =
                await checkEmailExists(email);


            if (emailExists) {

                if (registerSuccess) {

                    registerSuccess.textContent =
                        "This email is already registered.";

                    registerSuccess.classList.remove(
                        "text-primary"
                    );

                    registerSuccess.classList.add(
                        "text-danger"
                    );

                }

                return;

            }


            /* Registration successful */

            if (registerSuccess) {

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

            }


            alert(
                "Registration successful! Welcome, " +
                name +
                "!"
            );

            localStorage.setItem(
    "registeredUser",
    JSON.stringify({
        name: name,
        email: email,
        password: password
    })
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
   14. LOGIN EMAIL VALIDATION
===================================================== */

if (loginEmail) {

    loginEmail.addEventListener(
        "input",
        function () {

            const email =
                loginEmail.value.trim();

            const emailPattern =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


            if (
                email !== "" &&
                emailPattern.test(email)
            ) {

                loginEmail.classList.remove(
                    "is-invalid"
                );

                loginEmail.classList.add(
                    "is-valid"
                );

                if (loginEmailError) {

                    loginEmailError.textContent = "";

                }

            } else {

                loginEmail.classList.remove(
                    "is-valid"
                );

                if (email !== "") {

                    loginEmail.classList.add(
                        "is-invalid"
                    );

                }

            }

        }
    );

}


/* =====================================================
   15. LOGIN PASSWORD VALIDATION
===================================================== */

if (loginPassword) {

    loginPassword.addEventListener(
        "input",
        function () {

            const password =
                loginPassword.value;


            if (password.length >= 6) {

                loginPassword.classList.remove(
                    "is-invalid"
                );

                loginPassword.classList.add(
                    "is-valid"
                );

                if (loginPasswordError) {

                    loginPasswordError.textContent = "";

                }

            } else {

                loginPassword.classList.remove(
                    "is-valid"
                );

                if (password.length > 0) {

                    loginPassword.classList.add(
                        "is-invalid"
                    );

                }

            }

        }
    );

}


/* =====================================================
   16. REMEMBER ME
   LOAD SAVED EMAIL
===================================================== */

if (
    loginEmail &&
    rememberMe
) {

    const savedEmail =
        localStorage.getItem("rememberedEmail");


    if (savedEmail) {

        loginEmail.value =
            savedEmail;

        rememberMe.checked =
            true;

    }

}


/* =====================================================
   17. LOGIN FORM SUBMIT
===================================================== */

if (loginForm) {

    loginForm.addEventListener(
        "submit",
        function (event) {

            event.preventDefault();


            /* Get values */

            const email =
                loginEmail.value.trim();

            const password =
                loginPassword.value;


            /* Patterns */

            const emailPattern =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


            /* Clear errors */

            if (loginEmailError) {

                loginEmailError.textContent = "";

            }

            if (loginPasswordError) {

                loginPasswordError.textContent = "";

            }

            if (loginSuccess) {

                loginSuccess.classList.add(
                    "d-none"
                );

            }


            let isValid = true;


            /* Email */

            if (email === "") {

                if (loginEmailError) {

                    loginEmailError.textContent =
                        "Please enter your email address.";

                }

                loginEmail.classList.add(
                    "is-invalid"
                );

                isValid = false;

            } else if (
                !emailPattern.test(email)
            ) {

                if (loginEmailError) {

                    loginEmailError.textContent =
                        "Please enter a valid email address.";

                }

                loginEmail.classList.add(
                    "is-invalid"
                );

                isValid = false;

            }


            /* Password */

            if (password === "") {

                if (loginPasswordError) {

                    loginPasswordError.textContent =
                        "Please enter your password.";

                }

                loginPassword.classList.add(
                    "is-invalid"
                );

                isValid = false;

            } else if (
                password.length < 6
            ) {

                if (loginPasswordError) {

                    loginPasswordError.textContent =
                        "Password must contain at least 6 characters.";

                }

                loginPassword.classList.add(
                    "is-invalid"
                );

                isValid = false;

            }


            /* Stop if invalid */

            if (!isValid) {

                return;

            }


            /* =================================================
               DUMMY LOGIN
            ================================================= */

            /*
               Demo credentials:

               Email:
               test@gmail.com

               Password:
               123456
            */


            const registeredUser =
    JSON.parse(
        localStorage.getItem("registeredUser")
    );


if (
    registeredUser &&
    email === registeredUser.email &&
    password === registeredUser.password
) {

                /* Remember Me */

                if (
                    rememberMe &&
                    rememberMe.checked
                ) {

                    localStorage.setItem(
                        "rememberedEmail",
                        email
                    );

                } else {

                    localStorage.removeItem(
                        "rememberedEmail"
                    );

                }


                /* Success */

                if (loginSuccess) {

                    loginSuccess.classList.remove(
                        "d-none"
                    );

                    loginSuccess.innerHTML =
                        '<i class="bi bi-check-circle me-2"></i>' +
                        "Login successful! Welcome back.";

                }


                alert(
                    "Login successful! Welcome back."
                );


                loginForm.reset();


                if (rememberMe) {

                    const saved =
                        localStorage.getItem(
                            "rememberedEmail"
                        );

                    if (saved) {

                        loginEmail.value =
                            saved;

                        rememberMe.checked =
                            true;

                    }

                }


                loginEmail.classList.remove(
                    "is-valid",
                    "is-invalid"
                );

                loginPassword.classList.remove(
                    "is-valid",
                    "is-invalid"
                );


            } else {

                /* Invalid credentials */

                if (loginPasswordError) {

                    loginPasswordError.textContent =
                        "Invalid email or password.";

                }

                loginEmail.classList.add(
                    "is-invalid"
                );

                loginPassword.classList.add(
                    "is-invalid"
                );

            }

        }
    );

}


/* =====================================================
   18. BUTTON HOVER LOG
===================================================== */

const buttons =
    document.querySelectorAll(".btn");


buttons.forEach(
    function (button) {

        button.addEventListener(
            "mouseenter",
            function () {

                console.log(
                    "Mouse entered button:",
                    button.textContent.trim()
                );

            }
        );

    }
);


/* =====================================================
   19. PAGE LOAD EVENT
===================================================== */

window.addEventListener(
    "load",
    function () {

        console.log(
            "Task 2 page loaded successfully."
        );

    }
);