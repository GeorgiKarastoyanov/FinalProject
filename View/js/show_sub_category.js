
function getSubCategory(name) {
    console.log(name);
    fetch('View/allCategoryView.php', {
        method: 'POST',
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        body: 'category=' + name
    }).then(function (response) {
        return response.json();
    })
        .then(function (myJson) {
            console.log(myJson.subcategory)
        })
        .catch(function (e) {
            alert(e.message);
        })
}
