
function getSubCategory(name) {
    fetch('../index.php?target=category&action=showSubCat', {
        method: 'POST',
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        body: 'category=' + name
    }).then(function (response) {
        return response.json();
    })
        .then(function (myJson) {
            //console.log(myJson.subcategory)
            var buttons_div = document.getElementById("subCategories");
            buttons_div.innerHTML = "";
            for (var i = 0;i < myJson.length; i++){
                var button = document.createElement("button");
                button.value = myJson[i]["name"];
                button.innerHTML = myJson[i]["name"];
                buttons_div.appendChild(button);
            }
        })
        .catch(function (e) {
            alert(e.message);
        })
}
