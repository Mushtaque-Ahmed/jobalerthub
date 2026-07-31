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

}