
<!--<script src="js/show_sub_category.js"></script>-->
<br>
<!--<form action="../index.php?target=category&action=showAllCategories" method="get">-->
<input type="submit" onclick="getSubCategory('Mobile Phones')" name="Mobile Phones"
       value="Mobile Phones"> <br>
<input type="submit" onclick="getSubCategory('Large Appliances')" name="Large Appliances" value="Large Appliances"> <br>
<input type="submit" onclick="getSubCategory('Fashion')" name="Fashion" value="Fashion"> <br>
<input type="submit" onclick="getSubCategory('Hobby')" name="Hobby" value="Hobby"> <br>
<input type="hidden" value="">
<!--</form>-->

<div id="subCategories">

</div>

<script>
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
</script>