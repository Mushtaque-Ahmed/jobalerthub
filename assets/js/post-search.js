document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.getElementById("postSearch");
    const searchBtn = document.getElementById("searchBtn");
    const postContainer = document.getElementById("postContainer");
    const paginationArea = document.getElementById("paginationArea");


    if (!searchInput || !postContainer) {
        return;
    }


    let timer;


    if (searchInput) {


        searchInput.addEventListener("keyup", function () {

            clearTimeout(timer);


            timer = setTimeout(() => {

                loadPosts();

            }, 400);


        });


    }



    if (searchBtn) {

        searchBtn.addEventListener("click", function () {

            loadPosts();

        });

    }



    async function loadPosts(page = 1) {


        let search = searchInput ? searchInput.value : "";
        let url = BASE_URL + "api/post/listing.php?page="
            + page
            + "&search="
            + encodeURIComponent(search)



        try {


            let response = await fetch(url);

            let data = await response.json();



            if (!data.success) return;


            renderPosts(data.posts);


            renderPagination(data.pagination);


        } catch (error) {

            console.log(error);

        }


    }




    function renderPosts(posts) {


        if (posts.length === 0) {

            postContainer.innerHTML = `

<div class="col-12">

<div class="alert alert-warning text-center">

No result found.

</div>

</div>

`;

            return;

        }



        let html = "";


        posts.forEach(post => {


            html += `

<div class="col-lg-4 mb-4">

<div class="card shadow-sm h-100">


<img src="${BASE_URL}admin_hub/uploads/posts/${post.featured_image}"
class="card-img-top">


<div class="card-body d-flex flex-column">


<h5>${post.title}</h5>


<p>
<strong>Organization:</strong>
${post.organization}
</p>


<p>
<strong>Qualification:</strong>
${post.qualification}
</p>


<p>
<strong>Vacancy:</strong>
${post.total_posts}
</p>



<div class="mt-auto">

<a href="${BASE_URL}job/${post.slug}"
class="btn btn-primary w-100">

Read Details

</a>


</div>


</div>


</div>

</div>


`;

        });


        postContainer.innerHTML = html;


    }



    function renderPagination(pageData) {
        if (!paginationArea) {
            return;
        }

        if (pageData.total_pages <= 1) {

            paginationArea.innerHTML = "";

            return;

        }


        let html = `<ul class="pagination justify-content-center">`;


        for (let i = 1; i <= pageData.total_pages; i++) {


            html += `

<li class="page-item ${pageData.page == i ? 'active' : ''}">

<a href="#" 
class="page-link"
onclick="loadPosts(${i});return false;">

${i}

</a>

</li>

`;

        }


        html += "</ul>";


        paginationArea.innerHTML = html;


    }


});