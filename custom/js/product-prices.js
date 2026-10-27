const custo       = document.getElementById("custo-input");
const lucro       = document.getElementById("lucro-input");
const promoStatus = document.getElementById("in-promo-select");
const desconto    = document.getElementById("desconto-input");
const precoVenda  = document.getElementById("venda-input");
const precoPromo  = document.getElementById("promocao-input");
const estoque     = document.getElementById("estoque-input");

custo.addEventListener("input", e => {
    /** @type {HTMLInputElement} */
    const input = e.currentTarget;

    if (input.value.trim() === "") {
        lucro.value = "";
        lucro.disabled = true;
    }
    else {
        lucro.disabled = false;
    }
})

lucro.addEventListener("input", e => {
    /** @type {HTMLInputElement} */
    const input = e.currentTarget;

    // Não permitir 0 ser o primeiro digito com RegEx
    input.value = input.value.replace(/^0+/, "");

    const custoVal = parseFloat(custo.value);
    const lucro = parseFloat(1 + (input.value.replace('%', '') / 100));
    precoVenda.value = (custoVal * lucro).toFixed(2);

    if (input.value.trim() === "") {
        promoStatus.selectedIndex = 0;
        precoVenda.value = "";
        promoStatus.disabled = true;
    }
    else {
        promoStatus.disabled = false;
    }
})

promoStatus.addEventListener("change", e => {
    /** @type {HTMLSelectElement} */
    const input = e.currentTarget;
    const value = input.selectedIndex;

    if (value === 0) {
        desconto.disabled = true;
        desconto.value = "";
        precoPromo.value = "";
    }
    else {
        desconto.disabled = false;
    }
})

desconto.addEventListener("input", e => {
    /** @type {HTMLInputElement} */
    const input = e.currentTarget;

    // Não permitir 0 ser o primeiro digito com RegEx
    input.value = input.value.replace(/^0+/, "");

    const descontoVal = parseFloat(input.value.replace('%', ''));
    const precoVal = parseFloat(precoVenda.value);
    const lucroVal = parseFloat(lucro.value.replace('%', ''));
    const descontoCalc = parseFloat(1 - (descontoVal / 100));

    if (input.value.replace("%", "") === "" || input.value === "%") {
        input.value = "";
        precoPromo.value = "";
        return;
    };

    if (descontoVal >= lucroVal) {
        alert("Porcentagem de Promoção não pode ser maior ou igual ao do lucro!");
        input.value = "";
        precoPromo.value = "";
    }
    else {
        precoPromo.value = (precoVal * descontoCalc).toFixed(2);
    }
})