document.addEventListener("DOMContentLoaded", () => {

    const table = document.getElementById("pdfTable");
    const pagination = document.getElementById("pagination");

    const search = document.getElementById("search");
    const category = document.getElementById("categoryFilter");
    const status = document.getElementById("statusFilter");

    let currentPage = 1;

    loadData();

    search.addEventListener("keyup", () => {

        currentPage = 1;

        loadData();

    });

    category.addEventListener("change", () => {

        currentPage = 1;

        loadData();

    });

    status.addEventListener("change", () => {

        currentPage = 1;

        loadData();

    });

    async function loadData() {

        table.innerHTML = `
            <tr>
                <td colspan="9" class="text-center py-5">
                    Loading...
                </td>
            </tr>
        `;

        try {

            const response = await fetch(

                BASE_URL + `api/pdf/list.php?page=${currentPage}&search=${encodeURIComponent(search.value)}&category=${category.value}&status=${status.value}`

            );

            const result = await response.json();

            if (!result.success) {

                table.innerHTML = `
                    <tr>
                        <td colspan="9" class="text-center text-danger">
                            ${result.message}
                        </td>
                    </tr>
                `;

                return;

            }

            renderTable(result.data);

            renderPagination(result.page, result.total_pages);

        }

        catch (error) {

            console.error(error);

            table.innerHTML = `
                <tr>
                    <td colspan="9" class="text-center text-danger">
                        Server Error
                    </td>
                </tr>
            `;

        }

    }

    function renderTable(rows) {

        if (rows.length === 0) {

            table.innerHTML = `
                <tr>
                    <td colspan="9" class="text-center">
                        No PDF Found.
                    </td>
                </tr>
            `;

            return;

        }

        let html = "";

        rows.forEach(row => {

            html += `

            <tr>

                <td>

                    <img
                        src="${row.image}"
                        class="img-thumbnail"
                        style="width:60px;height:80px;object-fit:cover;">

                </td>

                <td>

                    <strong>${row.title}</strong>

                </td>

                <td>

                    ${row.category_name ?? "-"}

                </td>

                <td>

                    ${row.pages}

                </td>

                <td>

                    ${row.price_text}

                </td>

                <td>

                    ${row.downloads}

                </td>

             <td>

    <div class="form-check form-switch">

        <input
            class="form-check-input"
            type="checkbox"
            ${row.status == 1 ? "checked" : ""}
            onchange="toggleStatus(${row.id}, this)">

    </div>

</td>

                <td>

                    ${row.created}

                </td>

                <td>

                    <button
                        class="btn btn-warning btn-sm me-1"
                        onclick="editPDF(${row.id})">

                        <i class="bi bi-pencil"></i>

                    </button>

                    <button
                        class="btn btn-danger btn-sm"
                        onclick="deletePDF(${row.id})">

                        <i class="bi bi-trash"></i>

                    </button>

                </td>

            </tr>

            `;

        });

        table.innerHTML = html;

    }

    function renderPagination(page, totalPages) {

        pagination.innerHTML = "";

        if (totalPages <= 1) return;

        let html = `<ul class="pagination">`;

        for (let i = 1; i <= totalPages; i++) {

            html += `

            <li class="page-item ${page == i ? 'active' : ''}">

                <button
                    class="page-link"
                    onclick="gotoPage(${i})">

                    ${i}

                </button>

            </li>

            `;

        }

        html += "</ul>";

        pagination.innerHTML = html;

    }

    window.gotoPage = function (page) {

        currentPage = page;

        loadData();

    }
    function editPDF(id) {

        window.location.href =
            BASE_URL + "pdf/edit.php?id=" + id;

    }

    window.editPDF = editPDF;


    async function deletePDF(id) {

        if (!confirm("Are you sure you want to delete this PDF?")) {

            return;

        }

        const msg = document.getElementById("msg");

        function showMessage(type, message) {

            msg.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show">

                ${message}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>
        `;

        }

        const formData = new FormData();

        formData.append("id", id);

        try {

            const response = await fetch(

                BASE_URL + "api/pdf/delete.php",

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

                showMessage("success", result.message);

                loadData();

            }

        } catch (error) {

            console.error(error);

            showMessage(

                "danger",

                "Server Error."

            );

        }

    }
    window.deletePDF = deletePDF;

    // ==============status badge ===============
    async function toggleStatus(id, element) {

        const status = element.checked ? 1 : 0;

        const formData = new FormData();

        formData.append("id", id);
        formData.append("status", status);

        try {

            const response = await fetch(

                BASE_URL + "api/pdf/status.php",

                {
                    method: "POST",
                    body: formData
                }

            );

            const result = await response.json();

            const msg = document.getElementById("msg");

            msg.innerHTML = `
            <div class="alert alert-${result.success ? "success" : "danger"} alert-dismissible fade show">

                ${result.message}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>
        `;

            if (!result.success) {

                element.checked = !element.checked;

            }

        }

        catch (error) {

            element.checked = !element.checked;

            document.getElementById("msg").innerHTML = `
            <div class="alert alert-danger">

                Server Error.

            </div>
        `;

        }

    }
    window.toggleStatus = toggleStatus;
});