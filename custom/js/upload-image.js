/** @type {HTMLDivElement} */
const uploadArea = document.getElementById("upload-area");

/** @type {HTMLDivElement} */
const uploadView = document.getElementById("upload-view");

/** @type {HTMLDivElement} */
const uploadRowWrapper = document.getElementById("upload-row-wrapper");

/** @type {HTMLInputElement} */
const uploadInput = document.getElementById("upload-image-input");

// Isso é necessário, pois somente o atributo accept="image/png" por exemplo, não protege 100%, então validamos aqui no back-end também
const allowedTypes = ["image/png", "image/jpg", "image/jpeg", "image/webp"];
const limit = 4;

uploadArea.addEventListener("click", () => uploadInput.click());

uploadArea.addEventListener("change", () => {
    const fileList = [...uploadInput.files];

    const allowedFiles = fileList.filter(file => allowedTypes.includes(file.type));

    if (allowedFiles.length > 0) {
        // Só vou permitir pegar os 4 primeiros arquivos, pois no banco, é o que tenho
        const uploadableList = allowedFiles.sort((a, b) => a.name.localeCompare(b.name, undefined, { numeric: true, sensitivity: 'base' })).slice(0, 4);
        console.log(uploadableList);

        const dataTransfer = new DataTransfer();
        uploadableList.forEach(item => dataTransfer.items.add(item));

        uploadInput.files = dataTransfer.files;

        for (let i = 0; i < uploadInput.files.length; i++) {
            createUploads(uploadInput.files[i]);
        }
    }
})

uploadArea.addEventListener("drop", e => {
    // Isso previne de ao dropar algum arquivo na div, ele abrir em outra guia, bruh
    e.preventDefault();

    const fileList = [...e.dataTransfer.files];

    const allowedFiles = fileList.filter(file => allowedTypes.includes(file.type));

    if (allowedFiles.length > 0) {
        // Só vou permitir pegar os 4 primeiros arquivos, pois no banco, é o que tenho
        const uploadableList = allowedFiles.sort((a, b) => a.name.localeCompare(b.name, undefined, { numeric: true, sensitivity: 'base' })).slice(0, 4);
        console.log(uploadableList);

        const dataTransfer = new DataTransfer();
        uploadableList.forEach(item => dataTransfer.items.add(item));

        uploadInput.files = dataTransfer.files;
        for (let i = 0; i < uploadInput.files.length; i++) {
            createUploads(uploadInput.files[i]);
        }
    }
})

// Só cuidam de estilização
uploadArea.addEventListener("dragover", e => {
    e.preventDefault();

    const fileList = [...e.dataTransfer.items];
    const allowedFiles = fileList.filter(file => allowedTypes.includes(file.type));

    if (allowedFiles.length > 0) {
        uploadArea.classList.add("dragging-over");
    } 
})

uploadArea.addEventListener("dragleave", () => uploadArea.classList.remove("dragging-over"));

function createUploads(file) {
    const uploadRow = document.createElement("div");
    uploadRow.classList.add("upload-row");

    const imageRepresent = URL.createObjectURL(file);

    uploadRow.innerHTML =
    `
    <div class="upload-image-container"><img src="${imageRepresent}" alt="${file.name}" class="upload-image"></div>
    
    <div class="upload-details">
        <p class="upload-title">${file.name}</p>

        <span class="upload-progress-text">Começando em instantes...</span>
        <div class="upload-progress-bar-bg"><div class="upload-progress-bar"></div></div>

        <span class="upload-size">${(file.size / Math.pow(1024, 2)).toFixed(2)} MB</span>
    </div>

    <button type="button" class="upload-delete-button" title="Remover upload"><i class="fa-solid fa-xmark icon-upload-delete"></i></button>
    `;

    uploadRowWrapper.appendChild(uploadRow);

    // Remove da memória ao carregar a imagem
    const uploadedImage = document.querySelectorAll(".upload-image");
    uploadedImage.forEach(img => {
        img.onload = () => { URL.revokeObjectURL(imageRepresent); };
    })

    // Poderia fazer via Fetch, mas XMLHttpRequest tem suporte ao listener de "progress" para obter progressão do envio mediante cálculos
    const xhr = new XMLHttpRequest();
    const formData = new FormData();

    formData.append("produto_imagens[]", file);
    xhr.open("POST", "cadastrar-produto.php", true);

    // Analisar e descobrir como adicionar a animação de progresso para cada uploadRow
    xhr.upload.addEventListener("progress", e => {
        const progress = Math.round((e.loaded / e.total) * 100);
        
        const progressNumber = uploadRow.querySelector(".upload-progress-text");
        progressNumber.textContent = progress.toString() + '%';

        const progressBar = uploadRow.querySelector(".upload-progress-bar");
        progressBar.style.width = progress + "%";
    })

    xhr.send(formData);


    // Cancelar um upload
    const cancelUpload = uploadRow.querySelector(".upload-delete-button");
    cancelUpload.addEventListener("click", e => {
        e.stopPropagation();

        if (xhr.readyState !== XMLHttpRequest.DONE) {
            xhr.abort()
        }
    });

    xhr.upload.addEventListener("abort", e => {
        uploadRow.classList.add("deleted-row");
        URL.revokeObjectURL(imageRepresent);

        setTimeout(() => uploadRow.remove(), 750);
    });

    xhr.addEventListener("load", () => {
        if (xhr.status === 200) {
            const progressNumber = uploadRow.querySelector(".upload-progress-text");
            progressNumber.textContent = "Concluído!";
        }
    })
}

// Deletar a imagem do banco
const deleteUpload = document.querySelectorAll(".remove-upload");

deleteUpload.forEach(dr => {
    dr.addEventListener("click", async () => {
        if (!confirm("Tem certeza que quer excluir essa imagem deste produto?")) return;

        const imageName = dr.parentElement.querySelector(".upload-title").textContent;

        const columns = [ "imagem_principal", "imagem_2", "imagem_3", "imagem_4" ];
        const imageIndex = [...dr.parentElement.parentNode.children].indexOf(dr.parentElement);

        const data = {
            column: columns[imageIndex],
            image: imageName
        }

        console.log("Index é: " + imageIndex);
        console.log("Coluna é: " + columns[imageIndex]);

        try {
            const res = await fetch("../../admin/produto/deletar-imagem.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });

            if (res.status != 200) throw new Error("Código HTTP de falha, veja <deletar-imagem.php> em produtos/.");

            dr.parentElement.classList.add("deleted-row");
            setTimeout(() => dr.parentElement.remove(), 250);
        }
        catch (e) { console.error("Erro ao tentar excluir a imagem do banco de dados", e) }
    })
})
