document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("contactForm");

    if (!form) return;

    const messageBox = document.getElementById("messageBox");
    const captchaQuestion = document.getElementById("captchaQuestion");
    const submitBtn = document.getElementById("submitBtn");

    let captchaAnswer = 0;

    /* ==========================================
        Generate Captcha
    ========================================== */

    function generateCaptcha() {

        const num1 = Math.floor(Math.random() * 9) + 1;
        const num2 = Math.floor(Math.random() * 9) + 1;

        captchaAnswer = num1 + num2;

        captchaQuestion.textContent = `${num1} + ${num2} = ?`;

    }

    generateCaptcha();

    /* ==========================================
        Show Message
    ========================================== */

    function showMessage(type, text) {

        messageBox.innerHTML = `
            <div class="alert alert-${type}">
                ${text}
            </div>
        `;

        setTimeout(() => {
            messageBox.innerHTML = "";
        }, 5000);

    }

    /* ==========================================
        Submit Form
    ========================================== */

    form.addEventListener("submit", async function (e) {

        e.preventDefault();

        const name = form.name.value.trim();
        const email = form.email.value.trim();
        const subject = form.subject.value.trim();
        const message = form.message.value.trim();
        const captcha = parseInt(form.captcha.value);

        /* Validation */

        if (!name || !email || !subject || !message) {

            showMessage("danger", "Please fill in all fields.");

            return;

        }

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(email)) {

            showMessage("danger", "Please enter a valid email address.");

            return;

        }

        if (message.length < 10) {

            showMessage("danger", "Message should be at least 10 characters.");

            return;

        }

        if (captcha !== captchaAnswer) {

            showMessage("danger", "Incorrect captcha answer.");

            generateCaptcha();

            form.captcha.value = "";

            return;

        }

        submitBtn.disabled = true;

        submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm"></span>
            Sending...
        `;

        try {

            const formData = new FormData(form);

            const response = await fetch(BASE_URL + "api/contact/send.php", {

                method: "POST",

                body: formData

            });

            const result = await response.json();

            if (result.success) {

                showMessage("success", result.message);

                form.reset();

                generateCaptcha();

            } else {

                showMessage("danger", result.message);

                generateCaptcha();

            }

        } catch (error) {

            console.error(error);

            showMessage("danger", "Something went wrong. Please try again.");

        }

        submitBtn.disabled = false;

        submitBtn.innerHTML = `
            <i class="bi bi-send-fill"></i>
            Send Message
        `;

    });

});