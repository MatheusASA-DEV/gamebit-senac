const categoria = document.getElementById("categoria-select");
const submit = document.getElementById("submit-form-btn");

const inPromo = document.getElementById("in-promo-select");
const descInp = document.getElementById("desconto-input");

submit.addEventListener("click", e => {
    if (categoria.selectedIndex === 0) {
        alert("Selecione uma categoria!");
        e.preventDefault();
        return;
    }

    if (inPromo.selectedIndex === 1 && descInp.value.trim().replace("%", "") === "") {
        alert("O produto não possui um valor de desconto! Caso ele não deva possuir um desconto, mude o campo 'Em Promoção' para 'Não'.");
        e.preventDefault();
    }
})