const ctx = document.getElementById("product-most-sold");

// Gráfico de Estoque Baixo (Produtos com estoque baixo)
async function loadEstoqueBaixo() {
    try {
        const res = await fetch("../../admin/produto/api.php");
        
        if (res.ok) {
            const data = await res.json();

            new Chart(ctx, {
                type: "bar",
                indexAxis: 'y',
                data: {
                    labels: data.nomes,
                    datasets: [{
                        label: "Estoque",
                        data: data.estoques,
                        backgroundColor: "rgba(81, 190, 86, 0.33)",
                        borderColor: "rgb(81, 190, 90)",
                        borderWidth: 2
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { color: "rgba(255, 255, 255, 0.075)" }
                        },
                        y: {
                            grid: { color: "rgba(255, 255, 255, 0.075)" }
                        }
                    }
                }
            });
        }
    }
    catch (e) { console.warn("Erro overview-dashboard.js: ", e) }
}

document.addEventListener("DOMContentLoaded", () => {
    loadEstoqueBaixo();
})