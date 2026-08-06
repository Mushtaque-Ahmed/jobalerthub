

const searchInput = document.getElementById("searchInput");
const pdfContainer = document.getElementById("pdfContainer");
const paginationArea = document.getElementById("paginationArea");

let typingTimer;

searchInput.addEventListener("keyup", function () {

    clearTimeout(typingTimer);

    typingTimer = setTimeout(() => {

        loadPDFs(1, this.value);

    }, 300);

});

async function loadPDFs(page = 1, search = "") {

    try {

        const response = await fetch(
            BASE_URL + "api/pdf/listing.php?page=" + page + "&search=" + encodeURIComponent(search)
        );

        const data = await response.json();

        if (!data.success) return;

        renderPDFs(data.pdfs);

        renderPagination(data.pagination, search);

    } catch (e) {

        console.log(e);

    }

}

function renderPDFs(pdfs) {

    if (pdfs.length === 0) {

        pdfContainer.innerHTML = `
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    No PDF found.
                </div>
            </div>`;

        return;

    }

    let html = "";

    pdfs.forEach(pdf => {

        html += `

<div class="col-lg-3 col-md-4 col-sm-6 mb-4">

<div class="card shadow-sm h-100">

<img src="${BASE_URL}admin_hub/uploads/pdf-images/${pdf.featured_image}"
class="card-img-top"
style="height:250px;object-fit:cover;">

<div class="card-body d-flex flex-column">

<h6 class="fw-bold">${pdf.title}</h6>

<small class="text-muted">${pdf.pages} Pages</small>

<small class="text-muted">${pdf.language}</small>

<small class="text-muted">${pdf.author}</small>

<div class="mt-2">

${Number(pdf.is_free)
                ? '<span class="badge bg-success">FREE</span>'
                : `<span class="badge bg-danger">₹${pdf.price}</span>`
            }

</div>

<div class="mt-auto pt-3">

<a href="${BASE_URL}pdf/${encodeURIComponent(pdf.slug)}"
class="btn btn-primary w-100">

View Details

</a>

</div>

</div>

</div>

</div>`;

    });

    pdfContainer.innerHTML = html;

}

function renderPagination(pagination, search) {

    if (!pagination || pagination.total_pages <= 1) {

        paginationArea.innerHTML = "";

        return;

    }

    let html = '<ul class="pagination justify-content-center">';

    for (let i = 1; i <= pagination.total_pages; i++) {

        html += `
            <li class="page-item ${pagination.page == i ? 'active' : ''}">
                <a href="#" class="page-link"
                    onclick="loadPDFs(${i},'${search.replace(/'/g, "\\'")}');return false;">
                    ${i}
                </a>
            </li>`;
    }

    html += "</ul>";

    paginationArea.innerHTML = html;

}

