function filter() {
    var priceOrder = document.getElementById("priceFilter").value;
    var brand = document.getElementById("brandFilter").value;
    window.location = "?target=product&action=filter&priceOrder=" +priceOrder+"&brand="+brand;
}