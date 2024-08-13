function filterCards(searchQuery) {
  const cards = document.querySelectorAll(".one-card");
  cards.forEach(card => {
    const labName = card.querySelector("#lab-name").textContent.toLowerCase();
    const docName = card.querySelector("#doc-name").textContent.toLowerCase();
    const labType = card.querySelector("#lab-type").textContent.toLowerCase();
    const location = card.querySelector("#location").textContent.toLowerCase();
    const searchTerm = searchQuery.toLowerCase();
    if (labName.includes(searchTerm) || docName.includes(searchTerm) ||
        labType.includes(searchTerm) ||location.includes(searchTerm) ) {
      card.classList.remove("d-none") ;
    } else {
      card.classList.add("d-none");
    }
  });
}

const searchInput = document.getElementById("search-input");   

searchInput.addEventListener("input", () => {
  const searchQuery = searchInput.value;   

  filterCards(searchQuery);
});
