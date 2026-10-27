const consoleSection = document.getElementById("console-section");
const jogoSection = document.getElementById("jogo-section");
const categorySelect = document.getElementById("categoria-select");

document.addEventListener("DOMContentLoaded", () => {
    const categoryName = categorySelect.options[categorySelect.selectedIndex].textContent.toLowerCase();

    const console = categoryName === "consoles" || categoryName === "console";
    const jogo = categoryName === "jogos" || categoryName === "jogo";

    if (console) {
        consoleSection.hidden = !console;
        setTimeout(() => consoleSection.classList.toggle("shown", console));

        jogoSection.classList.remove("shown");
        jogoSection.hidden = true;
    }
    else if (jogo) {
        jogoSection.hidden = !jogo;
        setTimeout(() => jogoSection.classList.toggle("shown", jogo));

        consoleSection.classList.remove("shown");
        consoleSection.hidden = true;
    }
    else {
        jogoSection.classList.remove("shown");
        jogoSection.hidden = true;

        consoleSection.classList.remove("shown");
        consoleSection.hidden = true;
    }
})

categorySelect.addEventListener("change", () => {
    const categoryName = categorySelect.options[categorySelect.selectedIndex].textContent.toLowerCase();

    const console = categoryName === "consoles" || categoryName === "console";
    const jogo = categoryName === "jogos" || categoryName === "jogo";

    if (console) {
        consoleSection.hidden = !console;
        setTimeout(() => consoleSection.classList.toggle("shown", console));

        jogoSection.classList.remove("shown");
        jogoSection.hidden = true;
    }
    else if (jogo) {
        jogoSection.hidden = !jogo;
        setTimeout(() => jogoSection.classList.toggle("shown", jogo));

        consoleSection.classList.remove("shown");
        consoleSection.hidden = true;
    }
    else {
        jogoSection.classList.remove("shown");
        jogoSection.hidden = true;

        consoleSection.classList.remove("shown");
        consoleSection.hidden = true;
    }
})


// Habilitar/Desabilitar campo de inserção de Desconto com base na seleção de status promoção
const promoSelection = document.getElementById("in-promo-select");

/** @type {HTMLInputElement} */
const descontoInput = document.getElementById("desconto-input");

promoSelection.addEventListener("change", () => {
    const inPromo = promoSelection.options[promoSelection.selectedIndex].textContent === "Não";
    descontoInput.disabled = inPromo;
    descontoInput.value = "";
});