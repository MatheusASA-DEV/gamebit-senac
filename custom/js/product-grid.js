const filterSidebar = document.getElementById("filter-sidebar");
const mobOpenFilters = document.getElementById("open-filters");
const mobCloseFilter = document.getElementById("close-sidebar-button");

mobOpenFilters.addEventListener("click", () => {
    filterSidebar.classList.add("active");
})

mobCloseFilter.addEventListener("click" , () => {
    filterSidebar.classList.remove("active");
})

const filterAccordion = document.querySelectorAll(".filter-button-accordion");

filterAccordion.forEach(button => {
    button.addEventListener("click", () => {
        const filterOptions = button.nextElementSibling;
        const accordionIcon = button.querySelector(".icon-accordion");
        filterOptions.classList.toggle("active");
        accordionIcon.classList.toggle("opened");
    })
})