<?php 

if(isset($_POST["submit"])) {
    $input = $_POST["input"];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="page-wrapper">
    <div class="search-wrapper">
        <form action="index.php" method="post">
            <input name="input" class="search-box" type="text" placeholder="Search for a city or country...">
            <input type="submit" name="submit" class="btn btn-success submit-btn" value="submit">
        </form>
        <div class="displayW">
            <h4 class="wtitle"><h4>
            <p class="wtemp">&#176;C</p>
            <div class="dwsection">
                <img>
                <p></p>
            </div>            
        </div>
    </div>
    </div>
    
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script type="text/javascript">

    function getData(url) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", url);
            xhr.send();
            xhr.onload = () => {
                if(xhr.status === 200) {
                    resolve(xhr.response);
                } else {
                    reject(xhr.status + " " + xhr.statusText);
                }
            } 
            xhr.onerror = () => {
                reject("Network Error");
            }
        });
    }

    function success(data) {
        const dataObj = JSON.parse(data);
                const title = $(".displayW > .wtitle");
                title.append(dataObj.name);
                const icon = $(".dwsection > img");
                icon.prop("src", `http://openweathermap.org/img/wn/${dataObj.weather[0].icon}.png`);
                icon.prop("alt", dataObj.weather[0].description);
                const condition = $(".dwsection > p:last-child");
                condition.append(dataObj.weather[0].description);
                const temp = $(".wtemp");
                temp.prepend(ktoc(dataObj.main.temp) + " ");
    }

    function ktoc(k) {
        return (k - 273.15).toFixed(1);
    }

    function fail(error) {
        console.log(error);
        const title = $(".wtitle");
        title.append("Please enter a valid place");
        $(".wtemp").css("display", "none");
        $(".dwsection > img").css("display", "none");

        }

    $(function() {
        let location = "<?php echo $input?>";
        const apiKey = "a338c4fde6f61b103e057929f5497fa6";
        const url = `https://api.openweathermap.org/data/2.5/weather?q=${location}&appid=` + apiKey;
        getData(url)
            .then(function(data) {
                success(data);
            })
            .catch(function(error) {
                fail(error);
            })
    })
</script>
</body>
</html>