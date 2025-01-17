document.addEventListener("DOMContentLoaded", function(event) {
    validate();
    loadCV();
    const inputBuscar = document.getElementById("inputBuscar");

   inputBuscar.addEventListener("input", function () {
      const searchTerm = inputBuscar.value.trim();//trim elimina cualquier espacio en blanco al principio o al final del texto.
      loadCV(searchTerm);
   });

function loadCV(searchTerm = "") {//valor predeterminado en caso de no haber uno

    const url = searchTerm !== "" ? `php/cv.php?search=${searchTerm}` : "php/cv.php";
    fetch(url, {
        method: "GET"
    }).then(res => {
        if (res.status != 200) {
            throw new Error("Bad Server Response");
        }
        return res.json();
    }).then(res => {
        const divPersonas=document.querySelector(".grid__personas");
        divPersonas.innerHTML = '';
        const divBotonCrear=document.createElement("div");
        divBotonCrear.classList.add("boton-crear");
        
        const aCrear=document.createElement("a");
        aCrear.classList.add("boton-crear-usuario");
        aCrear.href="crear.html";

        const dicCentrar=document.createElement("div");
        dicCentrar.classList.add("centrar");

        const h1Mas=document.createElement("h1");
        h1Mas.classList.add("simbolo-crear");
        h1Mas.innerText="+";

        dicCentrar.appendChild(h1Mas);
        aCrear.appendChild(dicCentrar);
        divBotonCrear.appendChild(aCrear);
        divPersonas.appendChild(divBotonCrear);

        res.curriculum.forEach((item) => {
            const divBotonUser=document.createElement("div");
            divBotonUser.classList.add("boton__user");

            const BotonUserInfo=document.createElement("div");
            BotonUserInfo.classList.add("boton__user-informacion");

            const imgUser=document.createElement("img");
            imgUser.src="fotosUser/sin_fondo_"+item.foto;
            imgUser.classList.add("mostrar-foto");

            const h2User=document.createElement("h2");
            h2User.innerText=item.nombre;

            const aVer=document.createElement("a");
            aVer.classList.add("boton","boton-verde")
            aVer.innerText="Ver";
            aVer.href="user.php?id="+item.id;

            const aActualizar=document.createElement("a");
            aActualizar.classList.add("boton","boton-amarillo")
            aActualizar.innerText="Actualizar";
            aActualizar.href="actualizar.php?id="+item.id;

            const formEliminar=document.createElement("form");
            formEliminar.classList.add("w-100","eliminar");
            formEliminar.addEventListener('submit', deleteCV);

            const inputHidden=document.createElement("input");
            inputHidden.type="hidden";
            inputHidden.name="id";
            inputHidden.value=item.id;

            const inputHidden2=document.createElement("input");
            inputHidden2.type="hidden";
            inputHidden2.name="imagen";
            inputHidden2.value=item.foto;

            const aEliminar=document.createElement("input");
            aEliminar.classList.add("boton","boton-rojo")
            aEliminar.value="Eliminar";
            aEliminar.type="submit";

            formEliminar.appendChild(inputHidden);
            formEliminar.appendChild(inputHidden2);
            formEliminar.appendChild(aEliminar);

            BotonUserInfo.appendChild(imgUser);
            BotonUserInfo.appendChild(h2User);
            BotonUserInfo.appendChild(aVer);
            BotonUserInfo.appendChild(aActualizar);
            BotonUserInfo.appendChild(formEliminar);

            divBotonUser.appendChild(BotonUserInfo);

            divPersonas.appendChild(divBotonUser);
            

        });
    }).catch(err => console.error(err));
    return false;
}

 

function deleteCV(event) {
    event.preventDefault();
    const form = event.currentTarget;
    const formData = new FormData(form);
    fetch("php/cv2.php", {
        method: "POST",
        body: formData
    }).then(res => {
        if (res.status != 200) {
            throw new Error("Bad Server Response");
        }
        return res.json();
    }).then(res => {
        const body = document.querySelector(".bodyAdmin")
        const alerta = document.createElement("div");
        alerta.classList.add("alert");
        if (res.status == 200 || res.status==502) {

            const formParent = form.closest('.boton__user');
            if (formParent) {
                formParent.remove();
            }

            body.appendChild(alerta);
            alerta.innerText = res.description;
            alerta.style.backgroundColor = "green"
            setTimeout(function () {
                alerta.remove();
            }, 1500);

        } else {
            body.appendChild(alerta);
            alerta.innerText = res.description;
            alerta.style.backgroundColor = "red"
            setTimeout(function () {
                alerta.remove();
            }, 3000);
        }
    }).catch(err => console.error(err));

}

function cerrar_session(){
    const formData = new FormData();
    formData.append("salir", true);
    fetch("php/close.php", {
        method: "POST",
        body: formData
    }).then(res => {
        if (res.status != 200){ throw new Error("Bad Server Response"); }
        return res.json();
    }).then(res =>{
        if(res.status==200){
            document.location.href = 'login.html';
        }else{
            alert("Error al intentar cerrar la sesión");
        }
    }).catch(err => console.error(err));		
}

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
        }else if(res.status==200){
            const correo=document.querySelector("#emailDiv");
            correo.innerText=res.usuario;

            // const nombre=document.querySelector("#nombreDiv");
            // nombre.innerText=res.nombre;
        }
    }).catch(err => console.error(err));
}


const form = document.getElementById("cerrar");
form.addEventListener("click", cerrar_session);	

function isPageLoaded() {
    return document.readyState === "complete";
}

const loader = document.querySelector(".loader");

// Mostrar el loader si la página no ha cargado completamente
if (loader && !isPageLoaded()) {
    loader.style.display = "fixed";
}

// Ocultar el loader cuando la página ha cargado completamente
window.onload = function() {
    if (loader) {
        loader.style.display = "none";
    }
};

// Mostrar el loader durante la recarga manual de la página
window.onbeforeunload = function() {
    if (loader) {
        loader.style.display = "flex";
    }
};

});
