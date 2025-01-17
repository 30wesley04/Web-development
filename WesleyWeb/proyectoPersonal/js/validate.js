document.addEventListener("DOMContentLoaded", function(event) {
    validate();
function validate(){
    const formData  = new FormData();
    fetch("php/validate.php", {
        method: "POST",
        body: formData
    }).then(res => {
        if (res.status != 200){ throw new Error("Bad Server Response"); }
        return res.json();
    }).then(res =>{
        if(res.status==500){
            document.location.href = 'login.html';
        }
    }).catch(err => console.error(err));
}



});
