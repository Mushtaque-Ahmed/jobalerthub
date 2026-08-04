document
.getElementById("newsletterForm")
.addEventListener("submit", async function(e){

    e.preventDefault();

    const email=document
    .getElementById("newsletterEmail")
    .value
    .trim();

    if(email==="") return;

    const btn=this.querySelector("button");

    btn.disabled=true;

    btn.innerHTML="Please wait...";

    try{

        const res=await fetch(BASE_URL+"api/newsletter/subscribe.php",{

            method:"POST",

            headers:{
                "Content-Type":"application/json"
            },

            body:JSON.stringify({

                email

            })

        });

        const data=await res.json();

        Swal.fire({

            icon:data.success?"success":"error",

            title:data.message

        });

        if(data.success){

            this.reset();

        }

    }catch(e){

        Swal.fire({

            icon:"error",

            title:"Server Error"

        });

    }

    btn.disabled=false;

    btn.innerHTML="Subscribe";

});