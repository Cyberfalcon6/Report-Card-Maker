<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drop down</title>
    <script>
        function upd()
        {
            var province = document.getElementById('province').value;
            var xhr = new XMLHttpRequest;
            xhr.open("OPEN", "get_lower.php?province=".concat(province),true);
            xhr.send(null);
            xhr.onreadystatechange = function()
            {
                if(this.readyState===4)
                {
                    document.getElementById('district').innerHTML = this.responseText;
                }
            }
        }
    </script>
</head>
<body>
    <select onchange="upd()" name="" id="province">
          <?php
              $conn = mysqli_connect("localhost","root","");
              mysqli_select_db($conn, "places");
              $results = mysqli_query($conn, "SELECT * FROM `provinces`");
              foreach($results as $res)
              {
                echo "<option value='".$res['name']."'>".$res['name']."</option>";
              }

          ?>
    </select>
    <select name="district" id="district">

    </select>
</body>
</html>