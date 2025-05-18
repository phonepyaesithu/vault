function filterProducts() {
  // Collect checked boxes for brands
  var brandCheckboxes = document.querySelectorAll(".form-check-input:checked");
  var selectedBrands = [];
  var selectedCategories = [];

  brandCheckboxes.forEach(function (checkbox) {
    if (
      checkbox.id.includes("inlineCheckbox1") ||
      checkbox.id.includes("inlineCheckbox2") ||
      checkbox.id.includes("inlineCheckbox3")
    ) {
      // Brands
      selectedBrands.push(checkbox.value);
    } else {
      // Categories
      selectedCategories.push(checkbox.value);
    }
  });

  // AJAX request to fetch filtered products
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "filter_products.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Replace the current products section with the response from the server
      document.querySelector(".container .row").innerHTML = xhr.responseText;
    }
  };

  // Send both brands and categories to the server
  xhr.send(
    "brands=" +
      JSON.stringify(selectedBrands) +
      "&categories=" +
      JSON.stringify(selectedCategories)
  );
}

function clearFilters() {
  // Uncheck all checkboxes
  var checkboxes = document.querySelectorAll(".form-check-input");
  checkboxes.forEach(function (checkbox) {
    checkbox.checked = false;
  });

  // Re-filter products (reset to default)
  filterProducts();
}
