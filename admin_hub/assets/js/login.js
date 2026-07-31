document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("loginForm");
    const btn = document.getElementById("loginBtn");
    const msg = document.getElementById("msg");

    // Show / Hide Password
    const togglePassword = document.getElementById("togglePassword");
    const password = document.getElementById("password");

    togglePassword.addEventListener("click", () => {

        if (password.type === "password") {
            password.type = "text";
            togglePassword.innerHTML = "🙈";
        } else {
            password.type = "password";
            togglePassword.innerHTML = "👁";
        }

    });

    // Login
    form.addEventListener("submit", async function (e) {

        e.preventDefault();

        msg.innerHTML = "";

        btn.disabled = true;

        btn.innerHTML = `
            <span class="spinner"></span>
            Signing In...
        `;

        const formData = new FormData(form);

        try {

            const response = await fetch("api/login/login.php", {
                method: "POST",
                body: formData
            });

            // Read response as text first
            const text = await response.text();

            console.log("Server Response:");
            console.log(text);

            let result;

            try {
                result = JSON.parse(text);
            } catch (e) {

                msg.innerHTML = `
                    <div class="alert alert-danger">
                        Invalid JSON Response.<br>
                        Check Console (F12).
                    </div>
                `;

                console.error("JSON Parse Error");
                console.error(text);

                return;
            }

            if (result.success) {

                msg.innerHTML = `
                    <div class="alert alert-success">
                        ${result.message}
                    </div>
                `;

                setTimeout(() => {
                    window.location.href = result.redirect;
                }, 1000);

            } else {

                msg.innerHTML = `
                    <div class="alert alert-danger">
                        ${result.message}
                    </div>
                `;

            }

        } catch (error) {

            console.error(error);

            msg.innerHTML = `
                <div class="alert alert-danger">
                    ${error.message}
                </div>
            `;

        }

        btn.disabled = false;
        btn.innerHTML = "Login";

    });

});