document.addEventListener("DOMContentLoaded", function(event) {

    /*****Modificacion del campo cotraseña*****/
    const password=document.querySelector(".iconoPassword");
    const inputPassword=document.querySelector("#password");
    password.style.cursor = "pointer";

    password.addEventListener("click", function () {
        if (inputPassword.type === "password") {
            inputPassword.type = "text";
            password.classList.remove("fa-solid", "fa-eye-slash");
            password.classList.add("fa-solid","fa-eye");
        } else {
            inputPassword.type = "password";
            password.classList.remove("fa-solid","fa-eye");
            password.classList.add("fa-solid", "fa-eye-slash");
        }

        
    });

    /*****Funcion JWT*****/

    function jwt(){
		const formData  = new FormData();
		formData.append("jwt", true);
		fetch("php/jwt/", {
			method: "POST",
			body: formData
		}).then(res => {
			if (res.status != 200){ throw new Error("Bad Server Response"); }
			return res.json();
		}).then(res =>{
			if(res.status==200){
				document.getElementById('jwt').value = res.jwt;
			}
		}).catch(err => console.error(err));
	}

    /*****Funcion para validadar correo****/
    function isValidEmail(email) {
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return emailPattern.test(email);
    }

    /*****Funcion para el formulario de login*****/

    function logSubmit(event) {
        event.preventDefault();
        const emailInput = document.getElementById("email");
        const email = emailInput.value;

        if (!isValidEmail(email)) {
            const body=document.querySelector(".login__background")
            const alerta=document.createElement("div");
            alerta.classList.add("alert");
            alerta.innerText="Ingresa un correo electronico valido"
            alerta.style.backgroundColor="red"

            body.prepend(alerta);
            setTimeout(function () {
                alerta.remove(); 
            }, 3000);
            return; 
        }

        var data = new FormData(document.getElementById("formulario-login"));
        fetch("php/", {
            method: "POST",
            body: data
        }).then(res => {
            if (res.status != 200) { 
                throw new Error("Bad Server Response"); 
            }
            return res.json();
        }).then(res => {
            const body=document.querySelector(".login__background")
            const alerta=document.createElement("div");
            alerta.classList.add("alert");
            if (res.status == 200) {
                body.prepend(alerta);
                alerta.innerText = "Inicio de sesión como "+res.user.nombre;
                alerta.style.backgroundColor="green"
                setTimeout(function () {
                    alerta.remove(); 
                    document.location.href = 'index.php';
                }, 1500);
            } else {
                body.prepend(alerta);
                alerta.innerText = res.description;
                alerta.style.backgroundColor="red"
                setTimeout(function () {
                    alerta.remove(); 
                }, 3000);
            }
        }).catch(err => console.error(err));
    }

    jwt();
    const form = document.getElementById("formulario-login");
    form.addEventListener("submit", logSubmit);

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
