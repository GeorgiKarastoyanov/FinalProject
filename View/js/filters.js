function filter(page = 1) {
    var priceOrder = document.getElementById("priceFilter").value;
    var brand = document.getElementById("brandFilter").value;
    window.location = "?target=product&action=filter&priceOrder=" +priceOrder+"&brand="+brand + "&page=" +page;
}
function pager() {
    fetch("index.php?target=product&action=makePages")
        .then(function (response) {
            return response.json();
        })
        .then(function (myJson) {
            var total = myJson.totalProducts;
            var perPage = myJson.productsPerPage;
            var buttons = Math.ceil(total / perPage);
            var pagera = document.getElementById("pager");
            for (var i = 1; i <= buttons; i++) {
                var button = document.createElement("button");
                button.value = i;
                if(document.getElementById("hiddenPage").value == i){
                    button.style.backgroundColor = 'blue';
                }
                button.style.height = '20px';
                button.style.width = '20px';
                button.style.margin = '5px';
                button.innerHTML = i;
                button.addEventListener('click', function (i) {
                    return function () {
                        filter(i);
                    }
                }(i));
                pagera.appendChild(button);
            }

        });
}