async function buscarCep(cep) {
    const url = `https://viacep.com.br/ws/${cep}/json/`;

    const cidadeInput   = document.getElementById("cidade");
    const estadoInput   = document.getElementById("estado");
    const enderecoInput = document.getElementById("endereco");
    const bairroInput   = document.getElementById("bairro");

    cidadeInput.value   = "Buscando...";
    estadoInput.value   = "";
    enderecoInput.value = "Buscando...";
    bairroInput.value   = "Buscando...";

    try {
        const res = await fetch(url);

        if (res.ok) {
            const data = await res.json()

            cidadeInput.value   = data.localidade;
            estadoInput.value   = data.uf;
            enderecoInput.value = data.logradouro;
            bairroInput.value   = data.bairro;
        }
    } catch (e) { console.warn("Erro ao buscar por CEP: " + e); }
}

const cepInput = document.getElementById("cep");

cepInput.addEventListener("blur", () => {
    const cepValue = cepInput.value;

    buscarCep(cepValue);
});