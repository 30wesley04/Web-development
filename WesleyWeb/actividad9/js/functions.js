document.addEventListener("DOMContentLoaded", function (event) {

    function loadCards() {
        fetch("php/", {
            method: "POST"
        }).then(res => {
            if (res.status != 200) {
                throw new Error("Bad Server Response");
            }
            return res.json();
        }).then(res => {
            const cardInner=document.querySelector(".cards-container");
            
            res.data.forEach((item, index) => {
                const cardItem=document.createElement("div");
                cardItem.classList.add("card")
                
                
                const img = document.createElement("img");
                const div2=document.createElement("div");
                const titulo=document.createElement("h5");
                const description=document.createElement("p");
                const boton=document.createElement("a");


                img.classList.add("card-img-top","sizeImg");
                img.src = item.url; 

                div2.classList.add("card-body");

                titulo.classList.add("card-title");
                titulo.innerText=item.title;

                description.classList.add("card-text");
                description.innerText=item.description;

                boton.classList.add("btn" ,"btn-primary");
                boton.innerText="Enlace videojuego";

                cardInner.appendChild(cardItem);
                cardItem.appendChild(img);
                cardItem.appendChild(div2);
                
                div2.appendChild(titulo)
                div2.appendChild(description)
                div2.appendChild(boton)

            });
        }).catch(err => console.error(err));
        return false;
    }
    
    loadCards();
});
