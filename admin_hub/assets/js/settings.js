document.addEventListener("DOMContentLoaded",()=>{


const form=document.getElementById("settingsForm");
const btn=document.getElementById("saveBtn");


form.addEventListener("submit",function(e){

e.preventDefault();


let formData=new FormData(form);


btn.disabled=true;
btn.innerHTML="Saving...";



fetch(BASE_URL + "api/settings/update_settings.php",
{
method:"POST",
body:formData
}

)

.then(res=>res.json())

.then(data=>{

console.log(data);
if(data.status==="success"){


Swal.fire({

icon:"success",
title:"Success",
text:data.message

});


}
else{


Swal.fire({

icon:"error",
title:"Error",
text:data.message

});


}



})

.catch(error=>{


Swal.fire({

icon:"error",
title:"Server Error",
text:"Something went wrong"

});


console.log(error);


})


.finally(()=>{


btn.disabled=false;
btn.innerHTML="Save Settings";


});



});



});