document.addEventListener("DOMContentLoaded", function(event) {
    loadCV();

function loadCV() {
    fetch("php/search.php", {
        method: "GET"
    }).then(res => {
        if (res.status != 200) {
            throw new Error("Bad Server Response");
        }
        return res.json();
    }).then(res => {
        const divPersonas=document.querySelector(".grid__personas");
        res.curriculum.forEach((item) => {
            const divBotonUser=document.createElement("div");
            divBotonUser.classList.add("boton__user");

            const BotonUserInfo=document.createElement("div");
            BotonUserInfo.classList.add("boton__user-informacion");

            const imgUser=document.createElement("img");
            imgUser.src="fotosUser/"+item.foto;
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

});