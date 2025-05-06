function updateStatus(select) {
  select.classList.remove("green", "red", "orange");
  const value = select.value;

  if (value === "Finished") {
    select.classList.add("green");
  } else if (value === "Not Finished") {
    select.classList.add("red");
  } else if (value === "On Progress") {
    select.classList.add("orange");
  }
}

// Initialize colors on page load
window.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("select.statusDropdown").forEach((select) => {
    updateStatus(select);
  });
});
