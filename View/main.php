<?php
echo 'main';
echo PHP_EOL;
//if(!isset($_SESSION['user'])){
//    require_once "View/welcome.php";
//}
?>
<br>
<!--<form action="../index.php?target=category&action=showAllCategories" method="get">-->
<input type="submit" onclick="getSubCategory('Mobile Phones')" id="MobilePhones" name="Mobile Phones"
       value="Mobile Phones"> <br>
<input type="submit" onclick="getSubCategory('Large Appliances')" name="Large Appliances" value="Large Appliances"> <br>
<input type="submit" onclick="getSubCategory('Fashion')" name="Fashion" value="Fashion"> <br>
<input type="submit" onclick="getSubCategory('Hobby')" name="Hobby" value="Hobby"> <br>
<input type="hidden" value="">
<!--</form>-->


<script>
    function getSubCategory(name) {
        console.log(name);
        fetch('View/subCategory.php', {
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
</script>