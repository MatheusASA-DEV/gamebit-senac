const showableImage = document.querySelector(".showable-image");
const selectImageButton = document.querySelector(".select-image-button");
const clearImageButton = document.querySelector(".clear-image-button");

selectImageButton.addEventListener("change", e => {
    if (e.target.files.length > 0) {
        /** @type {HTMLInputElement} */
        const uploadedFile = e.target.files[0];

        if (uploadedFile.type.startsWith("image/")) {
            const tempURL = URL.createObjectURL(uploadedFile);
            showableImage.src = tempURL;

            selectImageButton.disabled = true;
            clearImageButton.disabled = true;

            showableImage.onload = () => {
                URL.revokeObjectURL(tempURL);

                selectImageButton.disabled = false;
                clearImageButton.disabled = false;
            }
        } else { alert("Selecione um arquivo do tipo imagem válido") }
    }
})

clearImageButton.addEventListener("click", () => {
    if (showableImage.getAttribute("src") != "") { showableImage.src = "" }
    else { alert("Nenhum arquivo de imagem selecionado para limpar o campo.") }
})