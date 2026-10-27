let searchOpen = false;
let navOpen = false;

// Botões de ação
const openSearch = document.getElementById("mob-open-search");
const openNav = document.getElementById("mob-open-nav");

// Ícones dos botões
const searchIcon = openSearch.firstElementChild;
const navIcon = openNav.firstElementChild;

// Ícones de botões que podem mudar
const searchIconID = "fa-magnifying-glass";
const navIconID = "fa-bars";

// Classes de gatilho
const searchClass = "open-search";
const navClass = "open-nav";

// Ícone de fechar ao acionar o evento
const closeIconID = "fa-xmark";

// Menus
const searchForm = document.getElementById("search-form");
const searchInput = document.getElementById("search-input");
const navMenu = document.getElementById("nav-header");


openSearch.addEventListener("click", () => {
    if (!searchOpen) {
        searchForm.classList.add(searchClass);
        searchOpen = true;

        searchIcon.classList.remove(searchIconID);
        searchIcon.classList.add(closeIconID);

        searchForm.addEventListener("transitionend", () => {
            searchInput.focus();
        }, { once: true });
    } else {
        searchForm.classList.remove(searchClass);
        searchOpen = false;

        searchIcon.classList.remove(closeIconID);
        searchIcon.classList.add(searchIconID);
    }
})

// Impedir de buscar caso não haja nenhum termo no input
searchForm.addEventListener("submit", async e => {
    if (searchInput.value.trim() == "") {
        e.preventDefault();

        const messageBox = document.createElement("div");
        messageBox.classList.add("message-box", "shown");

        messageBox.innerHTML =
        `
        <h4 class="message-title">Digite para pesquisar...</h4>
        <p class="message-body">Insira algum termo para buscar.</p>
        `;

        document.body.appendChild(messageBox);
        // Eu poderia evitar duplicar código de message-box.js criando uma função que recebe o elemento e adiciona o listener no momento que quero, mas por enquanto vou duplicar código aqui

        messageBox.addEventListener("click", e => e.currentTarget.classList.remove("shown"));

        // Função para usar operação assincrona para a animação da messagebox
        const delay = (ms) => new Promise(resolve => setTimeout(resolve, ms));

        await delay(3000);
        messageBox.click();

        await delay(250);
        messageBox.remove();
    }
})

openNav.addEventListener("click", () => {
    if (!navOpen) {
        navMenu.classList.add(navClass);
        navOpen = true;

        navIcon.classList.toggle(navIconID);
        navIcon.classList.toggle(closeIconID);
    } else {
        navMenu.classList.remove(navClass);
        navOpen = false;

        navIcon.classList.toggle(closeIconID);
        navIcon.classList.toggle(navIconID);
    }
})

// Instanciando SwiperJS ao carregar a página
document.querySelectorAll(".products-swiper").forEach(section => {
    new Swiper(section, {
        roundLengths: true,
        allowTouchMove: true,
        autoplay: { delay: 5000 },
        navigation: { prevEl: "#p-pagination-prev", nextEl: "#p-pagination-next" },
        resizeObserver: true,
        spaceBetween: 16,
        slidesPerView: "auto"
    })
})

// Fechar menu de pesquisa ao apertar ESC
document.addEventListener("keydown", e => {
    if (e.key === "Escape" || e.key === "Esc") {
        if (searchOpen && searchForm.classList.contains(searchClass)) {
            searchForm.classList.remove(searchClass);

            searchIcon.classList.remove(closeIconID);
            searchIcon.classList.add(searchIconID);

            searchInput.blur();
            searchOpen = false;
        }
    }
})