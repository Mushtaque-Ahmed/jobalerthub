document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("pdfForm");
    const btn = document.getElementById("saveBtn");
    const msg = document.getElementById("msg");

    const title = document.getElementById("title");
    const slug = document.getElementById("slug");

    const image = document.getElementById("featured_image");
    const preview = document.getElementById("preview");

    const pdf = document.getElementById("pdf_file");

    // ==========================
    // Summernote
    // ==========================

    $('#description').summernote({

        height: 300,

        callbacks: {

            onImageUpload: function () {

                alert("Image upload is disabled.");

            }

        }

    });
    function showMessage(type, message) {

        msg.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"></button>
        </div>
    `;

    }

    function clearMessage() {

        msg.innerHTML = "";

    }
    // ==========================
    // Auto Slug
    // ==========================

    title.addEventListener("keyup", function () {

        slug.value = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-|-$/g, "");

    });

    // ==========================
    // Image Preview + Validation
    // ==========================

    image.addEventListener("change", function () {

        const file = this.files[0];

        if (!file) return;

        if (file.type !== "image/webp") {

            msg.innerHTML = `
            <div class="alert alert-danger">
                Only WEBP image allowed.
            </div>`;

            this.value = "";

            return;

        }

        if (file.size > 102400) {

            msg.innerHTML = `
            <div class="alert alert-danger">
                Image size must be below 100 KB.
            </div>`;

            this.value = "";

            return;

        }

        preview.src = URL.createObjectURL(file);

    });

    // ==========================
    // PDF Validation
    // ==========================

    pdf.addEventListener("change", function () {

        const file = this.files[0];

        if (!file) return;

        if (file.type !== "application/pdf") {

            msg.innerHTML = `
            <div class="alert alert-danger">
                Only PDF files are allowed.
            </div>`;

            this.value = "";

            return;

        }

        if (file.size > 50 * 1024 * 1024) {

            msg.innerHTML = `
            <div class="alert alert-danger">
                PDF must be less than 50 MB.
            </div>`;

            this.value = "";

            return;

        }

    });

    // ==========================
    // Submit
    // ==========================

    form.addEventListener("submit", async function (e) {

        e.preventDefault();

        clearMessage();

        // Category
        if (document.getElementById("category_id").value == "") {

            showMessage("danger", "Please select a category.");

            return;

        }

        // Title
        if (title.value.trim().length < 5) {

            showMessage("danger", "Title must be at least 5 characters.");

            title.focus();

            return;

        }

        // Slug
        if (slug.value.trim() == "") {

            showMessage("danger", "Slug is required.");

            slug.focus();

            return;

        }

        // Thumbnail
        if (image.files.length == 0) {

            showMessage("danger", "Please select a thumbnail image.");

            return;

        }

        // PDF
        if (pdf.files.length == 0) {

            showMessage("danger", "Please select a PDF file.");

            return;

        }

        // Pages
        const pages = document.querySelector('[name="pages"]');

        if (pages.value == "" || parseInt(pages.value) <= 0) {

            showMessage("danger", "Please enter valid total pages.");

            pages.focus();

            return;

        }

        // Price
        const price = document.querySelector('[name="price"]');

        if (price.value == "" || parseFloat(price.value) < 0) {

            showMessage("danger", "Invalid price.");

            price.focus();

            return;

        }

        // External Download URL
        const url = document.querySelector('[name="external_download_link"]');

        if (
            url.value.trim() != "" &&
            !/^https?:\/\/.+/i.test(url.value.trim())
        ) {

            showMessage(
                "danger",
                "Please enter a valid download URL."
            );

            url.focus();

            return;

        }

        btn.disabled = true;

        btn.innerHTML = `
        <span class="spinner-border spinner-border-sm"></span>
        Saving...
    `;

        const formData = new FormData(form);

        formData.set(
            "description",
            $('#description').summernote("code")
        );

        try {

            const response = await fetch(
                BASE_URL + "api/pdf/create.php",
                {
                    method: "POST",
                    body: formData
                }
            );

            if (!response.ok) {

                throw new Error(
                    "HTTP Error : " + response.status
                );

            }

            const result = await response.json();

            showMessage(
                result.success ? "success" : "danger",
                result.message
            );

            if (result.success) {

                form.reset();

                $('#description').summernote("code", "");

                preview.removeAttribute("src");

                setTimeout(() => {

                    window.location.href =
                        BASE_URL + "pdf/index.php";

                }, 1200);

            }

        } catch (error) {

            console.error(error);

            showMessage(
                "danger",
                error.message || "Server Error"
            );

        } finally {

            btn.disabled = false;

            btn.innerHTML = "Save PDF";

        }

    });

});