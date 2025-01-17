document.addEventListener("DOMContentLoaded", function (event) {

    function loadBanner() {
        fetch("php/", {
            method: "POST"
        }).then(res => {
            if (res.status != 200) {
                throw new Error("Bad Server Response");
            }
            return res.json();
        }).then(res => {
            const carouselInner = document.querySelector(".carousel-inner");
            
            res.data.forEach((item, index) => {
                const carouselItem = document.createElement("div");
                carouselItem.classList.add("carousel-item");
                if (index === 0) {
                    carouselItem.classList.add("active");
                }
                
                const img = document.createElement("img");
                img.classList.add("d-block", "w-100");
                img.src = item.url; 
                
                carouselItem.appendChild(img);
                carouselInner.appendChild(carouselItem);
            });
        }).catch(err => console.error(err));
        return false;
    }

    function loadBanner2() {
		fetch("php/banner.php", {
			method: "GET"
		}).then(res => {
			if (res.status != 200){ 
				throw new Error("Bad Server Response"); 
			}
			return res.json();
		}).then(res =>{
			let html='',a=0;
			if(res.status==200){
				const elem = document.getElementById("imagesBanner2");
				elem.innerHTML = res.html;
			}else{
				alert("Error al recuperar datos");
			}
		}).catch(err => console.error(err));
		return false;	
	}
    
    loadBanner();
    loadBanner2();
});
