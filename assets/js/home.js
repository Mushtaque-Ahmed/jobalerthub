document.addEventListener("DOMContentLoaded", () => {

    loadHome();

});

async function loadHome() {

    try {

        const response = await fetch(BASE_URL + "api/home/home.php");

        const result = await response.json();

        if (!result.success) {



            return;

        }


    } catch (error) {

        console.error(error);

    }


    /* ========================================
         live search with result home page 
 =========================================*/
    const homeSearch = document.getElementById("homeSearch");
    const searchResults = document.getElementById("searchResults");

    const routeMap = {
        job: "job",
        result: "result",
        admit_card: "admit-card",
        answer_key: "answer-key",
        current_affairs: "current-affair"
    };

    if (homeSearch && searchResults) {

        let searchTimer;

        homeSearch.addEventListener("keyup", function () {

            clearTimeout(searchTimer);

            const keyword = this.value.trim();

            searchTimer = setTimeout(async () => {

                if (keyword.length < 2) {
                    searchResults.innerHTML = "";
                    searchResults.style.display = "none";
                    return;
                }

                try {

                    const response = await fetch(
                        BASE_URL + "api/search/search.php?q=" + encodeURIComponent(keyword)
                    );

                    const data = await response.json();

                    if (!data.success) {
                        searchResults.innerHTML = "";
                        searchResults.style.display = "none";
                        return;
                    }

                    let html = "";

                    // POSTS
                    data.posts.forEach(post => {

                        const url = `${BASE_URL}${routeMap[post.post_type] || "job"}/${post.slug}`;

                        html += `
                        <a href="${url}" class="search-item">

                            <img src="${BASE_URL}admin_hub/uploads/posts/${post.featured_image}"
                                 class="search-thumb"
                                 alt="${post.title}">

                            <div class="search-info">

                                <div class="search-title">
                                    ${post.title}
                                </div>

                                <div class="search-desc">
                                    ${post.organization ?? ""}
                                </div>

                                <span class="search-badge">
                                    ${post.post_type.replace("_", " ")}
                                </span>

                            </div>

                        </a>
                    `;
                    });

                    // PDF
                    data.pdfs.forEach(pdf => {

                        html += `
                        <a href="${BASE_URL}pdf/${pdf.slug}" class="search-item">

                            <img src="${BASE_URL}admin_hub/uploads/pdf-images/${pdf.featured_image}"
                                 class="search-thumb"
                                 alt="${pdf.title}">

                            <div class="search-info">

                                <div class="search-title">
                                    ${pdf.title}
                                </div>

                                <div class="search-desc">
                                    ${pdf.pages} Pages • ${pdf.language}
                                </div>

                                <span class="search-badge pdf">
                                    PDF
                                </span>

                            </div>

                        </a>
                    `;
                    });

                    if (html === "") {

                        html = `
                        <div class="search-empty">
                            No results found.
                        </div>
                    `;
                    }

                    searchResults.innerHTML = html;
                    searchResults.style.display = "block";

                } catch (error) {

                    console.error(error);

                }

            }, 300);

        });

        // Hide when clicking outside
        document.addEventListener("click", function (e) {

            if (!e.target.closest(".search-wrapper")) {

                searchResults.style.display = "none";

            }

        });

        // Show again when input is focused
        homeSearch.addEventListener("focus", function () {

            if (searchResults.innerHTML.trim() !== "") {

                searchResults.style.display = "block";

            }

        });

    }
}
