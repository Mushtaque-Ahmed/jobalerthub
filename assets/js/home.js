document.addEventListener("DOMContentLoaded", () => {

    loadHome();

});

async function loadHome() {

    try {

        const response = await fetch(BASE_URL + "api/home/home.php");

        const result = await response.json();

        if (!result.success) {

            console.log(result.message);

            return;

        }

        console.log(result.data);

    } catch (error) {

        console.error(error);

    }

}