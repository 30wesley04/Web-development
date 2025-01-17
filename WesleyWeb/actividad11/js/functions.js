document.addEventListener("DOMContentLoaded", function(event) {
    function isValidEmail(email) {
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return emailPattern.test(email);
    }

    function logSubmit(event) {
        event.preventDefault();
        const emailInput = document.getElementById("floatingInput");
        const email = emailInput.value;

        if (!isValidEmail(email)) {
            const bodyInner = document.querySelector(".body");
            const toast = document.createElement("div");
            toast.classList.add("toast", "align-items-center", "show", "text-white", "border-10");
            toast.setAttribute("role", "alert");
            toast.setAttribute("aria-live", "assertive");
            toast.setAttribute("aria-atomic", "true");

            const toastDiv = document.createElement("div");
            toastDiv.classList.add("d-flex");

            const toastText = document.createElement("div");
            toastText.classList.add("toast-body");

            const buttonT = document.createElement("button");
            buttonT.classList.add("btn-close", "btn-close-white", "me-2", "m-auto");
            buttonT.setAttribute("type", "button");
            buttonT.setAttribute("data-bs-dismiss", "toast");
            buttonT.setAttribute("aria-label", "Close");

            toastText.innerText = "Por favor, ingrese un correo electrónico válido.";
            toast.classList.add("bg-primary");

            bodyInner.prepend(toast);
            toast.appendChild(toastDiv);
            toastDiv.appendChild(toastText);
            toastDiv.appendChild(buttonT);

            return; 
        }

        var data = new FormData(document.getElementById("formulario"));
        fetch("php/", {
            method: "POST",
            body: data
        }).then(res => {
            if (res.status != 200) { 
                throw new Error("Bad Server Response"); 
            }
            return res.json();
        }).then(res => {
            const bodyInner = document.querySelector(".body");
            const toast = document.createElement("div");
            toast.classList.add("toast", "align-items-center", "show", "text-white", "border-10");
            toast.setAttribute("role", "alert");
            toast.setAttribute("aria-live", "assertive");
            toast.setAttribute("aria-atomic", "true");

            const toastDiv = document.createElement("div");
            toastDiv.classList.add("d-flex");

            const toastText = document.createElement("div");
            toastText.classList.add("toast-body");
			
			const buttonT = document.createElement("button");
            buttonT.classList.add("btn-close", "btn-close-white", "me-2", "m-auto");
            buttonT.setAttribute("type", "button");
            buttonT.setAttribute("data-bs-dismiss", "toast");
            buttonT.setAttribute("aria-label", "Close");

            bodyInner.prepend(toast);
            toast.appendChild(toastDiv);
            toastDiv.appendChild(toastText);
            toastDiv.appendChild(buttonT);
            
            if (res.status == 200) {
                toastText.innerText = "Inicio de sesión satisfactorio para el usuario: "+res.usuario;
                toast.classList.add("bg-success");
                // Mostrar el toast durante 1 segundo antes de redirigir
                setTimeout(function() {
                    toast.classList.remove('show')
                    document.location.href = "home.html";
                }, 1300);
            } else {
                toastText.innerText = "Error de usuario o contraseña";
                toast.classList.add("bg-danger");
                setTimeout(function() {
                    toast.classList.remove('show')
                }, 2000);
            }
        }).catch(err => console.error(err));
    }

    const form = document.getElementById("formulario");
    form.addEventListener("submit", logSubmit);

});
