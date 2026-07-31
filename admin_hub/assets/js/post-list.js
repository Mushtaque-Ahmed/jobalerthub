document.addEventListener("DOMContentLoaded", () => {

    let page = 1;

    loadPosts();

    // ===========================
    // Search
    // ===========================

    document.getElementById("search").addEventListener("keyup", () => {

        page = 1;

        loadPosts();

    });

    // ===========================
    // Load Posts
    // ===========================

    function loadPosts() {

        const search = document.getElementById("search").value;

        fetch(
            BASE_URL +
            "api/post/list.php?page=" +
            page +
            "&search=" +
            encodeURIComponent(search)
        )

            .then(res => res.json())

            .then(result => {

                let html = "";

                if (result.data.length === 0) {

                    html = `
                <tr>

                    <td colspan="9" class="text-center">

                        No Posts Found

                    </td>

                </tr>`;

                }

                result.data.forEach(row => {

                    html += `

<tr>

<td>${row.id}</td>

<td>

<img
src="${BASE_URL}uploads/posts/${row.featured_image}"
width="80"
class="rounded border">

</td>

<td>

<strong>${row.title}</strong>

</td>

<td>

${row.category_name ?? ''}

</td>

<td>

<span class="badge bg-info">

${row.post_type}

</span>

</td>

<td>

<span class="badge ${row.status == 'published'
                            ? 'bg-success'
                            : 'bg-secondary'}">

${row.status}

</span>

</td>

<td>

<a href="${BASE_URL}posts/view.php?id=${row.id}"
class="btn btn-info btn-sm me-1">

<i class="bi bi-eye"></i>

</a>

</td>

<td>

${row.created_at}

</td>

<td>

<button
class="btn btn-warning btn-sm me-1"
onclick="window.location.href='${BASE_URL}posts/edit.php?id=${row.id}'">

<i class="bi bi-pencil"></i>

</button>

<button
class="btn btn-danger btn-sm me-1"
onclick="deletePost(${row.id})">

<i class="bi bi-trash"></i>

</button>

<button
class="btn btn-sm ${row.status == 'published' ? 'btn-success' : 'btn-secondary'}"
onclick="toggleStatus(${row.id})">

${row.status == 'published'
                            ? '<i class="bi bi-check-circle"></i> Published'
                            : '<i class="bi bi-clock"></i> Draft'}

</button>

</td>

</tr>

`;

                });

                document.getElementById("postTable").innerHTML = html;

                pagination(result.total, result.limit);

            });

    }

    // ===========================
    // Pagination
    // ===========================

    function pagination(total, limit) {

        const pages = Math.ceil(total / limit);

        let html = "";

        for (let i = 1; i <= pages; i++) {

            html += `

<li class="page-item ${page == i ? 'active' : ''}">

<a
href="#"
class="page-link"
onclick="gotoPage(${i})">

${i}

</a>

</li>

`;

        }

        document.getElementById("pagination").innerHTML = html;

    }

    window.gotoPage = function (p) {

        page = p;

        loadPosts();

    }

    // ===========================
    // Edit
    // ===========================

    window.editPost = function (id) {

        window.location.href =
            BASE_URL +
            "posts/edit.php?id=" + id;

    }

    // ===========================
    // Delete
    // ===========================

    window.deletePost = async function (id) {

        if (!confirm("Delete this post?")) {

            return;

        }

        const fd = new FormData();

        fd.append("id", id);

        const res = await fetch(

            BASE_URL + "api/post/delete.php",

            {

                method: "POST",

                body: fd

            }

        );

        const result = await res.json();

        alert(result.message);

        if (result.success) {

            loadPosts();

        }

    }

    // ===========================
    // Publish / Draft
    // ===========================

    window.toggleStatus = async function (id) {

        const fd = new FormData();

        fd.append("id", id);

        const res = await fetch(

            BASE_URL + "api/post/status.php",

            {

                method: "POST",

                body: fd

            }

        );

        const result = await res.json();

        if (result.success) {

            loadPosts();

        }

    }

});
// ===========================
// Delete Post
// ===========================

window.deletePost = async function (id) {

    if (!confirm("Are you sure you want to delete this post?")) {
        return;
    }

    const msg = document.getElementById("msg");

    const formData = new FormData();
    formData.append("id", id);

    try {

        const response = await fetch(BASE_URL + "api/post/delete.php", {
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

            loadPosts();

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

};
// ===========================
// Toggle Status
// ===========================

window.toggleStatus = async function (id) {

    const msg = document.getElementById("msg");

    const formData = new FormData();

    formData.append("id", id);

    try {

        const response = await fetch(
            BASE_URL + "api/post/status.php",
            {
                method: "POST",
                body: formData
            }
        );

        const result = await response.json();

        msg.innerHTML = `
            <div class="alert alert-${result.success ? 'success' : 'danger'} alert-dismissible fade show">

                ${result.message}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>
        `;

        if (result.success) {

            loadPosts();

            setTimeout(() => {

                msg.innerHTML = "";

            }, 3000);

        }

    } catch (error) {

        msg.innerHTML = `
            <div class="alert alert-danger">

                Server Error.

            </div>
        `;

    }

};