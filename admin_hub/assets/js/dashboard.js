document.addEventListener("DOMContentLoaded", () => {

    loadDashboardStats();
    loadRecentPosts();
    

});

async function loadDashboardStats() {

    try {

        const response = await fetch(BASE_URL + "api/dashboard/stats.php");

        const result = await response.json();

        if (!result.success) {
            return;
        }

        const d = result.data;

        document.getElementById("totalCategories").textContent = d.categories;
        document.getElementById("totalPosts").textContent = d.posts;
        document.getElementById("publishedPosts").textContent = d.published;
        document.getElementById("draftPosts").textContent = d.draft;

        // These are optional cards (if you add them later)

        if (document.getElementById("todayPosts"))
            document.getElementById("todayPosts").textContent = d.today;

        if (document.getElementById("monthPosts"))
            document.getElementById("monthPosts").textContent = d.month;

        if (document.getElementById("totalViews"))
            document.getElementById("totalViews").textContent = d.views;

        if (document.getElementById("totalJobs"))
            document.getElementById("totalJobs").textContent = d.jobs;

    } catch (error) {

        console.error("Dashboard Error:", error);

    }

}

// recent post 
async function loadRecentPosts() {

    try {

        const response = await fetch(
            BASE_URL + "api/dashboard/recent-posts.php"
        );

        const result = await response.json();

        if (!result.success) return;

        let html = "";

        result.data.forEach(row => {

            html += `
            <tr>

                <td>${row.id}</td>

                <td>${row.title}</td>

                <td>${row.category ?? "-"}</td>

                <td>

                    <span class="badge bg-info">

                        ${row.post_type}

                    </span>

                </td>

                <td>

                    <span class="badge ${row.status === 'published'
                        ? 'bg-success'
                        : 'bg-secondary'}">

                        ${row.status}

                    </span>

                </td>

                <td>${row.created_at}</td>

                <td>

                    <a
                    href="${BASE_URL}posts/view.php?id=${row.id}"
                    class="btn btn-sm btn-info">

                        <i class="bi bi-eye"></i>

                    </a>

                    <a
                    href="${BASE_URL}posts/edit.php?id=${row.id}"
                    class="btn btn-sm btn-warning">

                        <i class="bi bi-pencil"></i>

                    </a>

                </td>

            </tr>
            `;

        });

        if (result.data.length === 0) {

            html = `
            <tr>

                <td colspan="7" class="text-center">

                    No posts found.

                </td>

            </tr>
            `;

        }

        document.getElementById("recentPostsTable").innerHTML = html;

    } catch (error) {

        console.error(error);

    }

}

// ==================for pdf =====================

document.addEventListener("DOMContentLoaded", () => {

    loadPDFStats();

});

async function loadPDFStats() {

    try {

        const response = await fetch(
            BASE_URL + "api/dashboard/pdf-stats.php"
        );

        const result = await response.json();

        

        if (!result.success) {

            return;

        }

        document.getElementById("totalPdf").textContent =
            result.data.total;

        document.getElementById("publishedPdf").textContent =
            result.data.published;

        document.getElementById("draftPdf").textContent =
            result.data.draft;

        document.getElementById("downloadPdf").textContent =
            result.data.downloads;

    }

    catch (error) {

        console.log(error);

    }

}