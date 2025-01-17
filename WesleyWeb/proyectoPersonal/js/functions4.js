document.addEventListener("DOMContentLoaded", function(event) {

    function cvSubmitPut(event) {
        event.preventDefault();

        var data = new FormData(document.getElementById("formulario-user-persona-actualizar"));
        fetch("php/cv3.php", {
            method: "POST",
            body: data
        }).then(res => {
            if (res.status != 200) {
                throw new Error("Bad Server Response");
            }
            return res.json();
        }).then(res => {
            const body = document.querySelector(".user__background")
            const alerta = document.createElement("div");
            alerta.classList.add("alert");
            if (res.status == 200 ) {
                body.appendChild(alerta);
                alerta.innerText = res.description;
                alerta.style.backgroundColor = "green"
                setTimeout(function () {
                    alerta.remove();
                    document.location.href = 'index.php';
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

    newNeed();
    newFrustration();
    newTech();
    newImage();

    const formCv = document.getElementById("formulario-user-persona-actualizar");
    formCv.addEventListener("submit", cvSubmitPut);

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

function loadTech(selectTecnologia) {
    fetch("php/tech.php", {
        method: "GET"
    }).then(res => {
        if (res.status != 200) {
            throw new Error("Bad Server Response");
        }
        return res.json();
    }).then(res => {
        res.tech.forEach((item) => {
            const tecnologiaOption = document.createElement("option");
            tecnologiaOption.value = item.id;
            tecnologiaOption.innerText = item.nombre;
            selectTecnologia.appendChild(tecnologiaOption);

        });
    }).catch(err => console.error(err));
    return false;
}

function newFrustration() {
    const frustrationsButton = document.querySelector("#frustrationsButton");
    const frustrationsDiv = document.querySelector("#frustrations");
    frustrationsButton.addEventListener('click', function () {
        const newFrustration = document.createElement('textarea');
        newFrustration.name = "frustrations[]";
        newFrustration.classList.add('w-100');
        frustrationsDiv.insertBefore(newFrustration, frustrationsButton);
    });
}

function newNeed() {
    const needsDiv = document.querySelector("#needs");
    const needsButton = document.querySelector("#needsButton");

    needsButton.addEventListener('click', function () {
        const newNeed = document.createElement("textarea");
        newNeed.name = "needs[]";
        newNeed.classList.add("w-100");

        needsDiv.insertBefore(newNeed, needsButton);
    })
}

var selectElements = document.querySelectorAll('select[name="tecnologias_id[]"]');

// Verifica si se encontraron elementos select
if (selectElements.length > 0) {
  // Recupera el último elemento select
  var ultimoSelect = selectElements[selectElements.length - 1];
} 
var ultimoId=ultimoSelect.id
var partes = ultimoId.split("tecnologia");
var numero = parseInt(partes[1]);
var t

let techCount=(numero+1);
function newTech() {
    
    const techDiv = document.querySelector(".tecnologias");
    const techButton = document.querySelector("#tecnologiaButton");
    
    techButton.addEventListener('click', function () {
        
        let puntoCount = 5;
        const tecnologia = document.createElement('div');
        tecnologia.classList.add("tecnologia");

        const selectTech = document.createElement("select");
        selectTech.name = "tecnologias_id[]";
        selectTech.id = "tecnologia" + techCount;

        const fistOption = document.createElement("option");
        fistOption.value = "";
        fistOption.innerText = "--Seleccione--";
        fistOption.selected = true;
        fistOption.disabled = true;

        selectTech.appendChild(fistOption);
        tecnologia.appendChild(selectTech);
        techDiv.insertBefore(tecnologia, techButton);

        techCount++;
        loadTech(selectTech);

        const divRating = document.createElement("div");
        divRating.classList.add("rating");
        for (let i = 0; i < 5; i++) {
            const inputTech = document.createElement("input");
            inputTech.type = "radio";
            const atributoFor = "tecnologia" + (techCount-1) + "-punto" + puntoCount;
            inputTech.id = atributoFor;
            inputTech.name = "calificacion[" + (techCount - 1) + "]";
            inputTech.value = puntoCount;
            puntoCount--;

            const labelTech = document.createElement("label");
            labelTech.setAttribute("for", atributoFor)

            divRating.appendChild(inputTech);
            divRating.appendChild(labelTech);

        }
        tecnologia.appendChild(divRating);

    })
}

function newImage() {
    const imagenUsuario = document.getElementById('imagen-usuario');
    const inputImagen = document.getElementById('input-imagen');

    imagenUsuario.addEventListener('click', () => {
        inputImagen.click();
    });

    inputImagen.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                imagenUsuario.src = event.target.result;
                imagenUsuario.classList.remove("imgPreview");
            };
            reader.readAsDataURL(file);
        }
    });
}
