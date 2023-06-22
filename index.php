
<DOCTYPE! html>
    <html>

    <head>
        <title>Mouses Shop "EShop"</title>
    </head>

    <script>
        var ajax = new XMLHttpRequest();
        function getInfoOfCategory() {
            var category = document.getElementById("category").value;
            ajax.open("GET", "actions/categories.php?category=" + category, true);
            ajax.send();
            ajax.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var xmlDoc = this.responseXML;
                    var table = "<table border='1'>";
                    table += "<tr><th>Name</th><th>Price</th><th>Number</th><th>Category</th></tr>";
                    var items = xmlDoc.getElementsByTagName("item");
                    for (var i = 0; i < items.length; i++) {
                        table += "<tr>";
                        table += "<td>" + items[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + "</td>";
                        table += "<td>" + items[i].getElementsByTagName("price")[0].childNodes[0].nodeValue + "</td>";
                        table += "<td>" + items[i].getElementsByTagName("quantity")[0].childNodes[0].nodeValue + "</td>";
                        table += "<td>" + items[i].getElementsByTagName("category")[0].childNodes[0].nodeValue + "</td>";
                        table += "</tr>";
                    }
                    table += "</table>";
                    document.getElementById("result2").innerHTML = table;
                }
            }
        }
        function getRangeOfPrice(type) {
            var minPrice = document.getElementById("minPrice").value;
            var maxPrice = document.getElementById("maxPrice").value;
            ajax.open("GET", "actions/rangeOfPrices.php?minPrice=" + minPrice + "&maxPrice=" + maxPrice, true);
            ajax.send();
            ajax.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var result = this.response;
                    var items = JSON.parse(result);
                    document.getElementById("result3").innerHTML = items;
                }
            }
        }
        function getManufacturer() {
            var manufacturerName = document.getElementById("manufacturerName").value;
            ajax.open("GET", "actions/manufacturer.php?manufacturerName=" + manufacturerName, true);
            ajax.send();
            ajax.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("result1").innerHTML = this.responseText;
                }
            }
        }
        

    </script>

    <body>
        
        
        <h1 align = "center"> Mouses Shop </h1>
        <h2 align = "center">Виконав: Ковальов Єгор Євгенійович</h2>
        <h2 align = "center">ст.гр. КІУКІ-20-3</h2>
        <h3 align = "center">Варіант: 5</h3>

        <hr>
        <h2>Product of the selected manufacturer</h2>
        <select name="manufacturerName" id="manufacturerName">
            <?php
            include("connect.php");
            try {
                $sqlSelect = "SELECT * FROM vendors";
                $stmt = $dbh->prepare($sqlSelect);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    echo "<option value='" . $row['v_name'] . "'>" . $row['v_name'] . "</option>";
                }
                echo "";
            } catch (PDOException $ex) {
                echo $ex->GetMessage();
            }
            ?>
        </select>
        <button onclick="getManufacturer()">Get </button>

        <div id="result1"></div>

        <hr>
        <h2>Product of the selected category</h2>

        <select name="category" id="category">
            <?php
            include("connect.php");
            try {
                $sqlSelect = "SELECT * FROM category";
                $stmt = $dbh->prepare($sqlSelect);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    echo "<option value='" . $row['c_name'] . "'>" . $row['c_name'] . "</option>";
                }
            } catch (PDOException $ex) {
                echo $ex->GetMessage();
            }
            ?>
        </select>
        <button onclick="getInfoOfCategory()">Get XML</button>
        <div id="result2"></div>

        <hr>
        <h2>Product of the selected range of prices</h2>

        <?php
        include("connect.php");
        try {
            echo "<input type='number' id='minPrice' name='minPrice' step='100' value='1000'>";
            echo "<input type='number' id='maxPrice' name='maxPrice' step='100' value='80000'>";

        } catch (PDOException $ex) {
            echo $ex->GetMessage();
        }
        ?>

        <button onclick="getRangeOfPrice()">Get JSON</button>
        <div id="result3"></div>
        <hr>
    </body>

    </html>