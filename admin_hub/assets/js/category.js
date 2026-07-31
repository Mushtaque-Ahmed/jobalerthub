document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("categoryForm");
    const name = document.getElementById("name");
    const slug = document.getElementById("slug");
    const msg = document.getElementById("msg");
    const btn = document.getElementById("saveBtn");

    name.addEventListener("keyup", () => {

        slug.value = name.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-|-$/g, "");

    });

    form.addEventListener("submit", async (e) => {

        e.preventDefault();

        btn.disabled = true;
        btn.innerHTML = "Saving...";

        const formData = new FormData(form);

        try {

            const response = await fetch(BASE_URL + "api/category/create.php", {

                method: "POST",
                body: formData

            });

            const result = await response.json();

            if (result.success) {

                msg.innerHTML = `
<div class="alert alert-success">
${result.message}

</div>`;

                form.reset();

            } else {

                msg.innerHTML = `
<div class="alert alert-danger">
${result.message}
</div>`;

            }
            loadCategories();

        } catch {

            msg.innerHTML = `
<div class="alert alert-danger">
Server Error
</div>`;
        }

        btn.disabled = false;
        btn.innerHTML = "Save Category";

    });

});

// =================category list / display ====================================
let page = 1;

loadCategories();

document.getElementById("search").addEventListener("keyup", () => {
    page = 1;
    loadCategories();
});

function loadCategories() {

    const search = document.getElementById("search").value;

    fetch(BASE_URL + "api/category/list.php?page=" + page + "&search=" + encodeURIComponent(search))
        .then(res => res.json())
        .then(result => {

            let html = "";

            result.data.forEach(row => {

                html += `
<tr>

<td>${row.id}</td>

<td>${row.name}</td>

<td>${row.slug}</td>

<td><i class="${row.icon}"></i> ${row.icon}</td>

<td>

<span class="badge ${row.status == 1 ? 'bg-success' : 'bg-danger'}">

${row.status == 1 ? 'Active' : 'Inactive'}

</span>

</td>

<td>${row.created_at}</td>

<td>

<button
class="btn btn-sm btn-primary me-1"
onclick="editCategory(${row.id})">
<i class="bi bi-pencil-square"></i>
</button>


<button
class="btn btn-sm btn-danger"
onclick="deleteCategory(${row.id})">

<i class="bi bi-trash"></i>

</button>


</td>

</tr>
`;

            });

            document.getElementById("categoryTable").innerHTML = html;

            pagination(result.total, result.limit);

        });

}

function pagination(total, limit) {

    const pages = Math.ceil(total / limit);

    let html = "";

    for (let i = 1; i <= pages; i++) {

        html += `
<li class="page-item ${page == i ? 'active' : ''}">

<a href="#" class="page-link"
onclick="gotoPage(${i})">

${i}

</a>

</li>`;

    }

    document.getElementById("pagination").innerHTML = html;

}

function gotoPage(p) {

    page = p;

    loadCategories();

}

//========================= delete category ===========================
async function deleteCategory(id) {

    if (!confirm("Are you sure you want to delete this category?")) {
        return;
    }

    const msg = document.getElementById("msg");

    const formData = new FormData();
    formData.append("id", id);

    try {

        const response = await fetch(BASE_URL + "api/category/delete.php", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        msg.innerHTML = `
            <div class="alert alert-${result.success ? 'success' : 'danger'} alert-dismissible fade show" role="alert">
                ${result.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        if (result.success) {

            loadCategories();

            // Auto hide message after 3 seconds
            setTimeout(() => {
                msg.innerHTML = "";
            }, 3000);
        }

    } catch (error) {

        msg.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Server error. Please try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

    }

}

// ===================================edit and update =================================================

async function editCategory(id) {

    const modal = new bootstrap.Modal(
        document.getElementById("editModal")
    );

    modal.show();

    const response = await fetch(
        BASE_URL + "api/category/get.php?id=" + id
    );

    const result = await response.json();

    if (!result.success) {

        alert(result.message);
        return;

    }

    document.getElementById("edit_id").value = result.data.id;
    document.getElementById("edit_name").value = result.data.name;
    document.getElementById("edit_slug").value = result.data.slug;
    document.getElementById("edit_icon").value = result.data.icon;
    document.getElementById("edit_status").value = result.data.status;

}
// ===========================update category ===================
const editName = document.getElementById("edit_name");
const editSlug = document.getElementById("edit_slug");

if (editName && editSlug) {

    editName.addEventListener("keyup", function () {

        editSlug.value = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-|-$/g, "");

    });

}
document.getElementById("updateBtn").addEventListener("click", async () => {

    const form = document.getElementById("editForm");

    const formData = new FormData(form);

    const response = await fetch(
        BASE_URL + "api/category/update.php",
        {
            method: "POST",
            body: formData
        }
    );

    const result = await response.json();

    document.getElementById("editMsg").innerHTML = `
        <div class="alert alert-${result.success ? "success" : "danger"
        }">
            ${result.message}
        </div>
    `;

    if (result.success) {

        loadCategories();

        setTimeout(() => {

            bootstrap.Modal
                .getInstance(document.getElementById("editModal"))
                .hide();

        }, 1000);

    }

});