document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("pdfForm");
    const msg = document.getElementById("msg");

    const title = document.getElementById("title");
    const slug = document.getElementById("slug");

    const image = document.getElementById("featured_image");
    const preview = document.getElementById("preview");

    const pdf = document.getElementById("pdf_file");
    const currentPdf = document.getElementById("currentPdf");

    // =============================
    // Summernote
    // =============================

    $('#description').summernote({

        height: 300,

        callbacks: {

            onImageUpload: function () {

                alert("Image upload is disabled.");

            }

        }

    });

    // =============================
    // Message
    // =============================

    function showMessage(type, message) {

        if (type === "") {

            msg.innerHTML = "";

            return;

        }

        msg.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show">

            ${message}

            <button
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>
    `;

    }

    // =============================
    // Auto Slug
    // =============================

    title.addEventListener("keyup", function () {

        slug.value = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-|-$/g, "");

    });

    // =============================
    // Load PDF
    // =============================

    loadPDF();

    async function loadPDF() {

        try {

            const response = await fetch(

                BASE_URL + "api/pdf/get.php?id=" + PDF_ID

            );

            const result = await response.json();

            if (!result.success) {

                showMessage("danger", result.message);

                return;

            }

            const p = result.data;

            document.getElementById("pdf_category_id").value = p.pdf_category_id;

            title.value = p.title;

            slug.value = p.slug;

            document.getElementById("short_description").value =
                p.short_description;

            $('#description').summernote("code", p.description);

            document.getElementById("author").value = p.author;

            document.getElementById("language").value = p.language;

            document.getElementById("pages").value = p.pages;

            document.getElementById("price").value = p.price;

            document.getElementById("is_free").value = p.is_free;

            document.getElementById("external_download_link").value =
                p.external_download_link;

            document.getElementById("seo_title").value =
                p.seo_title;

            document.getElementById("seo_description").value =
                p.seo_description;

            document.getElementById("seo_keywords").value =
                p.seo_keywords;

            document.getElementById("status").value =
                p.status;

            if (p.featured_image) {

                preview.src =
                    BASE_URL +
                    "uploads/pdf-images/" +
                    p.featured_image;

            }

            if (p.pdf_file) {

                currentPdf.innerHTML =
                    "<strong>Current PDF:</strong> " +
                    p.pdf_file;

            }

        }

        catch (error) {

            console.error(error);

            showMessage(
                "danger",
                "Unable to load PDF."
            );

        }

    }

    // =============================
    // Thumbnail Preview
    // =============================

    image.addEventListener("change", function () {

        if (!this.files.length) return;

        preview.src =
            URL.createObjectURL(this.files[0]);

    });

    // ============================= 
    // Validate New PDF
    // =============================

    pdf.addEventListener("change", function () {

        if (!this.files.length) return;

        const file = this.files[0];

        if (file.type !== "application/pdf") {

            showMessage(
                "danger",
                "Only PDF file allowed."
            );

            this.value = "";

            return;

        }

        if (file.size > 50 * 1024 * 1024) {

            showMessage(
                "danger",
                "PDF must be below 50 MB."
            );

            this.value = "";

        }

    });



    // =============================
    // Update PDF
    // =============================

    form.addEventListener("submit", async function (e) {

        e.preventDefault();

        showMessage("", "");

        const btn = document.getElementById("updateBtn");

        btn.disabled = true;

        btn.innerHTML = `
        <span class="spinner-border spinner-border-sm"></span>
        Updating...
    `;

        const formData = new FormData(form);

        formData.set(
            "description",
            $('#description').summernote("code")
        );

        try {

            const response = await fetch(

                BASE_URL + "api/pdf/update.php",

                {

                    method: "POST",

                    body: formData

                }

            );

            const result = await response.json();

            showMessage(

                result.success ? "success" : "danger",

                result.message

            );

            if (result.success) {

                setTimeout(() => {

                    window.location.href =
                        BASE_URL + "pdf/index.php";

                }, 1200);

            }

        }

        catch (error) {

            console.error(error);

            showMessage(

                "danger",

                "Server Error."

            );

        }

        btn.disabled = false;

        btn.innerHTML = "Update PDF";

    });
});