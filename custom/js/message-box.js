// Fechar mensagem ao clicar sobre
const messageBox = document.querySelectorAll(".message-box.shown");
messageBox.forEach(box => {
    box.addEventListener("click", () => box.classList.remove("shown"));
})