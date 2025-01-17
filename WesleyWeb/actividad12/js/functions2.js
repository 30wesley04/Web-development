document.addEventListener("DOMContentLoaded", function(event) {
function loadMenu() {
    fetch("php/menu.php", {
        method: "POST"
    }).then(res => {
        if (res.status != 200) {
            throw new Error("Bad Server Response");
        }
        return res.json();
    }).then(res => {
        const ulInner=document.querySelector("#ulHtml");
        
        res.data.forEach((item, index) => {
            const liElement=document.createElement("li");
            const classes = item.icono.split(' ');

            
            
            const aElement = document.createElement("a");
            aElement.classList.add("nav-link")
            if(index===0){
                aElement.classList.add( "text-secondary");
            }else{
                aElement.classList.add( "text-white");
            }
            aElement.setAttribute("href",item.url);
            

            const iElement=document.createElement("i");
            
            
            iElement.classList.add("bi", "d-block" ,"mx-auto", "mb-1")
            classes.forEach(className => {
                iElement.classList.add(className);
            });
            aElement.innerText=item.nombre


            ulInner.appendChild(liElement);
            liElement.appendChild(aElement);
            aElement.prepend(iElement);
            

        });
    }).catch(err => console.error(err));
    return false;
}

loadMenu();
});