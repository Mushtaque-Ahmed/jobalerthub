document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("categoryForm");
    const name = document.getElementById("name");
    const slug = document.getElementById("slug");
    const btn = document.getElementById("saveBtn");
    const msg = document.getElementById("msg");

    // Auto slug
    name.addEventListener("keyup", () => {

        slug.value = name.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-|-$/g, "");

    });

    // Submit Form
    form.addEventListener("submit", async (e) => {

        e.preventDefault();

        btn.disabled = true;
        btn.innerHTML = "Saving...";

        const formData = new FormData(form);

        try {

            const response = await fetch(
                BASE_URL + "api/pdf-category/create.php",
                {
                    method: "POST",
                    body: formData
                }
            );

            const result = await response.json();

            msg.innerHTML = `
                <div class="alert alert-${result.success ? "success" : "danger"} alert-dismissible fade show" role="alert">
                    ${result.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;

            if (result.success) {

                form.reset();

                // Reload category list (if available)
                if (typeof loadCategories === "function") {
                    loadCategories();
                }

                setTimeout(() => {

                    const modalEl = document.getElementById("addCategoryModal");

                    const modal = bootstrap.Modal.getInstance(modalEl);

                    if (modal) {
                        modal.hide();
                    }

                }, 800);

            }

        } catch (error) {

            msg.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Server error. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;

        }

        btn.disabled = false;
        btn.innerHTML = "Save Category";

    });

    // Reset form when modal closes
    document.getElementById("addCategoryModal")
        .addEventListener("hidden.bs.modal", () => {

            form.reset();
            msg.innerHTML = "";

        });
    loadCategories();



});


// =======================
// Load PDF Categories
// =======================

loadCategories();

function loadCategories() {

    fetch(BASE_URL + "api/pdf-category/list.php")
        .then(res => res.json())
        .then(result => {

            let html = "";

            if (result.success && result.data.length > 0) {

                result.data.forEach((row, index) => {

                    html += `
                    <tr>

                        <td>${index + 1}</td>

                        <td>${row.name}</td>

                        <td>${row.slug}</td>

                        <td>
                            <span class="badge bg-${row.status == 1 ? "success" : "danger"}">
                                ${row.status == 1 ? "Active" : "Inactive"}
                            </span>
                        </td>

                        <td>

                            <button class="btn btn-sm btn-primary"
                                onclick="editCategory(${row.id})">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <button class="btn btn-sm btn-danger"
                                onclick="deleteCategory(${row.id})">
                                <i class="bi bi-trash"></i>
                            </button>

                        </td>

                    </tr>
                    `;

                });

            } else {

                html = `
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No PDF Categories Found
                        </td>
                    </tr>
                `;

            }

            document.getElementById("categoryTable").innerHTML = html;

        });

}


// edit list 
// =======================
// Edit Category
// =======================

async function editCategory(id) {

    const modal = new bootstrap.Modal(
        document.getElementById("editCategoryModal")
    );

    modal.show();

    const response = await fetch(
        BASE_URL + "api/pdf-category/get.php?id=" + id
    );

    const result = await response.json();

    if (!result.success) {

        alert(result.message);
        modal.hide();
        return;

    }

    document.getElementById("edit_id").value = result.data.id;
    document.getElementById("edit_name").value = result.data.name;
    document.getElementById("edit_slug").value = result.data.slug;
    document.getElementById("edit_status").value = result.data.status;

}

// =======================================
// Update PDF Category
// =======================================

// =======================================
// Edit Form
// =======================================

const editForm = document.getElementById("editCategoryForm");
const updateBtn = document.getElementById("updateBtn");
const editMsg = document.getElementById("editMsg");

// Auto Slug
const editName = document.getElementById("edit_name");
const editSlug = document.getElementById("edit_slug");

if (editName && editSlug) {

    editName.addEventListener("keyup", () => {

        editSlug.value = editName.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-|-$/g, "");

    });

}

editForm.addEventListener("submit", async (e) => {

    e.preventDefault();

    updateBtn.disabled = true;
    updateBtn.innerHTML = "Updating...";

    const formData = new FormData(editForm);

    try {

        const response = await fetch(
            BASE_URL + "api/pdf-category/update.php",
            {
                method: "POST",
                body: formData
            }
        );

        const result = await response.json();

        editMsg.innerHTML = `
            <div class="alert alert-${result.success ? "success" : "danger"} alert-dismissible fade show">
                ${result.message}
                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
            </div>
        `;

        if (result.success) {

            loadCategories();

            setTimeout(() => {

                bootstrap.Modal
                    .getInstance(document.getElementById("editCategoryModal"))
                    .hide();

                editMsg.innerHTML = "";

            }, 800);

        }

    } catch (error) {

        editMsg.innerHTML = `
            <div class="alert alert-danger">
                Server error. Please try again.
            </div>
        `;

    }

    updateBtn.disabled = false;
    updateBtn.innerHTML = "Update Category";

});

// Reset Edit Modal
document.getElementById("editCategoryModal")
    .addEventListener("hidden.bs.modal", () => {

        editForm.reset();
        editMsg.innerHTML = "";



    });
window.deleteCategory = async function (id) {

    if (!confirm("Delete this category?")) {
        return;
    }

    const formData = new FormData();
    formData.append("id", id);

    try {

        const response = await fetch(
            BASE_URL + "api/pdf-category/delete.php",
            {
                method: "POST",
                body: formData
            }
        );

        const result = await response.json();

        alert(result.message);

        if (result.success) {

            loadCategories();

        }

    } catch (error) {

        alert("Server error.");

    }

}