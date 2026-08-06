document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("editPostForm");
    const btn = document.getElementById("updateBtn");
    const msg = document.getElementById("msg");

    const title = document.getElementById("title");
    const slug = document.getElementById("slug");

    // Summernote
    $('#description').summernote({
        height: 350
    });

    // Auto Slug
    title.addEventListener("keyup", function () {

        slug.value = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-|-$/g, "");

    });

    // Load Post
    loadPost();

    async function loadPost() {

        const response = await fetch(
            BASE_URL + "api/post/get.php?id=" + POST_ID
        );

        const result = await response.json();

        if (!result.success) {

            msg.innerHTML = `
            <div class="alert alert-danger">
                ${result.message}
            </div>
            `;

            return;

        }
        const p = result.data;

        // ===============================
        // Basic Information
        // ===============================

        document.getElementById("category_id").value = p.category_id;
        document.getElementById("post_type").value = p.post_type;

        document.getElementById("title").value = p.title;
        document.getElementById("slug").value = p.slug;

        document.getElementById("short_description").value =
            p.short_description ?? "";

        $('#description').summernote('code', p.description ?? "");

        // ===============================
        // Job Information
        // ===============================

        document.getElementById("organization").value =
            p.organization ?? "";

        document.getElementById("qualification").value =
            p.qualification ?? "";

        document.getElementById("total_posts").value =
            p.total_posts ?? "";

        document.getElementById("age_limit").value =
            p.age_limit ?? "";

        document.getElementById("salary").value =
            p.salary ?? "";

        document.getElementById("application_fee").value =
            p.application_fee ?? "";

        document.getElementById("apply_start").value =
            p.apply_start ?? "";

        document.getElementById("apply_last").value =
            p.apply_last ?? "";

        document.getElementById("exam_date").value =
            p.exam_date ?? "";

        document.getElementById("result_date").value =
            p.result_date ?? "";

        document.getElementById("official_website").value =
            p.official_website ?? "";

        document.getElementById("apply_link").value =
            p.apply_link ?? "";

        // ===============================
        // SEO
        // ===============================

        document.getElementById("seo_title").value =
            p.seo_title ?? "";

        document.getElementById("seo_description").value =
            p.seo_description ?? "";

        document.getElementById("seo_keywords").value =
            p.seo_keywords ?? "";

        // ===============================
        // Publish
        // ===============================

        document.getElementById("status").value =
            p.status;
        document.getElementById("is_breaking").checked = Number(p.is_breaking) === 1;
        // ===============================
        // Image
        // ===============================

        document.getElementById("old_image").value =
            p.featured_image ?? "";

        if (p.featured_image) {

            document.getElementById("preview").src =
                BASE_URL + "uploads/posts/" + p.featured_image;

        }

    }
    // ====================================
    // Live Image Preview
    // ====================================

    document.getElementById("featured_image")
        .addEventListener("change", function () {

            const file = this.files[0];

            if (!file) return;

            // WEBP Validation

            if (file.type !== "image/webp") {

                msg.innerHTML = `
        <div class="alert alert-danger">
            Only WEBP image allowed.
        </div>`;

                this.value = "";

                return;

            }

            // 100 KB Validation

            if (file.size > 102400) {

                msg.innerHTML = `
        <div class="alert alert-danger">
            Image must be below 100 KB.
        </div>`;

                this.value = "";

                return;

            }

            document.getElementById("preview").src =
                URL.createObjectURL(file);

        });
    // =====================================
    // Update Post
    // =====================================

    form.addEventListener("submit", async function (e) {

        e.preventDefault();

        msg.innerHTML = "";

        btn.disabled = true;

        btn.innerHTML = `
        <span class="spinner-border spinner-border-sm"></span>
        Updating...
    `;

        // Basic Validation

        if (title.value.trim() === "") {

            msg.innerHTML = `
        <div class="alert alert-danger">
            Title is required.
        </div>`;

            btn.disabled = false;
            btn.innerHTML = "Update Post";

            return;
        }

        if (slug.value.trim() === "") {

            msg.innerHTML = `
        <div class="alert alert-danger">
            Slug is required.
        </div>`;

            btn.disabled = false;
            btn.innerHTML = "Update Post";

            return;
        }

        const formData = new FormData(form);

        formData.set(
            "description",
            $('#description').summernote("code")
        );

        try {

            const response = await fetch(

                BASE_URL + "api/post/update.php",

                {
                    method: "POST",
                    body: formData
                }

            );

            const result = await response.json();

            msg.innerHTML = `
        <div class="alert alert-${result.success ? "success" : "danger"}">

            ${result.message}

        </div>`;

            if (result.success) {

                setTimeout(() => {

                    window.location.href =
                        BASE_URL + "posts/index.php";

                }, 1200);

            }

        } catch (error) {

            console.error(error);

            msg.innerHTML = `
        <div class="alert alert-danger">

            Server Error.

        </div>`;

        }

        btn.disabled = false;

        btn.innerHTML = `
        <i class="bi bi-check-circle"></i>
        Update Post
    `;

    });

});
