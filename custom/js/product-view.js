let detailsOpen = false;
const detailsButton = document.getElementById("show-main-details");
const details = document.getElementById("main-details");

detailsButton.addEventListener("click", () => {
    if (!detailsOpen) {
        detailsButton.classList.add("open");
        details.classList.add("active");
        detailsOpen = true;
    } else {
        detailsButton.classList.remove("open");
        details.classList.remove("active");
        detailsOpen = false;
    }
})

// Seleção de visualização de imagem de produto
const imageDisplay = document.getElementById("big-image-container").children[0];
const imageMini = document.querySelectorAll(".image-mini");

imageMini.forEach(mini => {
    mini.addEventListener("click", () => {
        imageMini.forEach(m => m.classList.remove("selected"));
        
        const miniImage = mini.children[0];
        const miniSrc = miniImage.src;

        if (miniSrc != "") {  
            imageDisplay.src = miniSrc;
            mini.classList.add("selected");
        };
    })
})