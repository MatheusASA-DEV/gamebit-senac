const navigationAccordion = document.querySelectorAll(".navigation-accordion");

navigationAccordion.forEach(button => {
    button.addEventListener("click", () => {
        const navigationOptions = button.nextElementSibling;
        navigationOptions.classList.toggle("opened");
    })
})

// Sair da conta
const accountButton = document.getElementById("admin-user");
const settings = document.querySelector(".account-settings");

accountButton.addEventListener("click", () => {
    settings.classList.toggle("active");
})