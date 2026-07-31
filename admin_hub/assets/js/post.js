
//  ==============================create post ============================
document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("postForm");
    const btn = document.getElementById("saveBtn");
    const msg = document.getElementById("msg");

    const title = document.getElementById("title");
    const slug = document.getElementById("slug");
    const image = document.getElementById("featured_image");
    const preview = document.getElementById("preview");

    // ===========================
    // Summernote
    // ===========================

    $('#description').summernote({

        height: 350,

        placeholder: 'Write post description...',

        toolbar: [

            ['style', ['style']],

            ['font', ['bold', 'italic', 'underline']],

            ['para', ['ul', 'ol', 'paragraph']],

            ['table', ['table']],

            ['insert', ['link']],

            ['view', ['fullscreen', 'codeview']]

        ]

    });

    // ===========================
    // Auto Slug
    // ===========================

    title.addEventListener("input", () => {

        slug.value = title.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-|-$/g, "");

    });

    // ===========================
    // Image Preview
    // ===========================

    image.addEventListener("change", function () {

        const file = this.files[0];

        if (!file) return;

        // WebP only

        if (file.type !== "image/webp") {

            showMessage("Only WEBP image allowed.", "danger");

            this.value = "";

            preview.classList.add("d-none");

            return;

        }

        // Max 100 KB

        if (file.size > 100 * 1024) {

            showMessage("Image size must be below 100 KB.", "danger");

            this.value = "";

            preview.classList.add("d-none");

            return;

        }

        const reader = new FileReader();

        reader.onload = function (e) {

            preview.src = e.target.result;

            preview.classList.remove("d-none");

        };

        reader.readAsDataURL(file);

    });

    // ===========================
    // Submit
    // ===========================

    form.addEventListener("submit", async function (e) {

        e.preventDefault();

        msg.innerHTML = "";

        // Validation

        if (document.getElementById("category_id").value == "") {

            return showMessage("Select category.");

        }

        if (title.value.trim() == "") {

            return showMessage("Title is required.");

        }

        if (slug.value.trim() == "") {

            return showMessage("Slug is required.");

        }

        if (image.files.length == 0) {

            return showMessage("Featured image required.");

        }

        const shortDesc = document.getElementById("short_description").value.trim();

        if (shortDesc.length < 20) {

            return showMessage("Short description minimum 20 characters.");

        }

        const description = $('#description').summernote('code');

        if (description === "" || description === "<p><br></p>") {

            return showMessage("Description is required.");

        }

        btn.disabled = true;

        btn.innerHTML = `
            <span class="spinner-border spinner-border-sm"></span>
            Saving...
        `;

        const formData = new FormData(form);

        formData.set("description", description);

        try {

            const response = await fetch(BASE_URL + "api/post/create.php", {

                method: "POST",

                body: formData

            });

            const result = await response.json();

            showMessage(result.message, result.success ? "success" : "danger");

            if (result.success) {

                form.reset();

                $('#description').summernote('reset');

                preview.classList.add("d-none");

            }

        }

        catch {

            showMessage("Server error.");

        }

        btn.disabled = false;

        btn.innerHTML = "Publish Post";

    });

    // ===========================
    // Alert
    // ===========================

    function showMessage(text, type = "danger") {

        msg.innerHTML = `
            <div class="alert alert-${type}">
                ${text}
            </div>
        `;

        window.scrollTo({

            top: 0,

            behavior: "smooth"

        });

    }

});