function searchProducts(query) {
  if (query.length === 0) {
    document.getElementById("searchResults").innerHTML = "";
    return;
  }

  // Send an AJAX request to shop.php with the search query
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "search.php?search=" + encodeURIComponent(query), true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Display the search results in the modal
      document.getElementById("searchResults").innerHTML = xhr.responseText;
    }
  };
  xhr.send();
}
