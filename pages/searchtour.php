<div style='background-color: rgba(173, 216, 230, 0.2); width:100%'>
    <form action="index.php?page=searchtour" method="get">
        <input name="page" value="searchtour" style='height: 0;visibility: hidden'>
        <input id="hot" name="hot" value="<?php echo ($_GET['hot'] == 1) ? 1 : 0 ?>"
               style='height: 0;visibility: hidden'>
        <script>
            function onChangeCountry(country) {
                $.post('functions.php', {get_states: 0, country: country.value}, function (data) {
                    let states = $('#states')[0].options;
                    for (i = states.length; i > 0; i--) {
                        states[i] = null;
                    }
                    data = JSON.parse(data);
                    states = $('#states');
                    data.forEach(function (state) {
                        states.append("<option value='" + state['id'] + "'>" + state['state'] + "</option>")
                    }
                );
                });
            }
        </script>
        <div style="display:flex;">
            <div style="margin:10px;">
                <select class="custom-select" style='width:200px;' id="countries" name="country"
                        onchange="onChangeCountry(this)">
                    <option value="0">Выбрать страну</option>
                    <?php
                    $countries = getCountries();
                    while ($row = mysqli_fetch_array($countries)) {
                        echo "<option value='" . $row['id'] . ($row['id'] == $_GET['country'] ? "'selected>" : "'>") . $row['country'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div style="margin:10px;">
                <select class="custom-select" style='width:200px;' id="states" name="state">
                    <option value="0">Выбрать город</option>
                    <?php
                    if (isset($_GET['country'])) {
                        $states = getStates($_GET['country']);
                        if (isset($states)) {
                            while ($row = mysqli_fetch_array($states)) {
                                echo "<option value='" . $row['id'] . ($row['id'] == $_GET['state'] ? "'selected>" : "'>") . $row['state'] . "</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>
            <div style="margin:10px;">
                <select class="custom-select" style='width:200px;' id="nutrition" name="nutrition">
                    <option value="0">Выбрать тип питания</option>
                    <?php
                    $nutritions = [
                        "1" => "без питания",
                        "2" => "завтрак",
                        "3" => "завтрак + ужин",
                        "4" => "3-разовое",
                        "5" => "все включено"];
                    $i = 1;
                    while ($i < 6) {
                        echo "<option value='" . $i . ($i == $_GET['nutrition'] ? "'selected>" : "'>") . $nutritions[$i] . "</option>";
                        $i++;
                    }
                    ?>
                </select>
            </div>
        </div>
        <button style='margin:10px;' type="submit" class='btn btn-primary'>Поиск</button>
    </form>
</div>
<div id="hotel-container">
    <script>
        let page = 1;

        function onLoadMore() {
            let country = $("#countries")[0].value;
            let state = $("#states")[0].value;
            let hot = $("#hot")[0].value;
            let nutrition = $("#nutrition")[0].value;
            $.post('functions.php', {
                get_hotels: 0,
                country: country,
                state: state,
                hot: hot,
                nutrition: nutrition,
                page: page
            }, function (data) {
                page++;
                data = JSON.parse(data);
                let hotels = $('#hotel-container');
                if (data == null) {
                    $("#loadMore").remove();
                } else {
                    data.forEach(function (hotel) {
                        hotels.append("<div class='list-item'>\n" +
                            "<img src='../images/uploads/" + hotel["photo-path"] + "' style='min-width:200px;width:200px;height:133px;align-self:center'>" +
                            "<div style='margin-left:10px;margin-top:5px;margin-right:10px; width:100%;'>" +
                            "<a href='/index.php?page=hotel&id=" + hotel['id'] + "' class='title'>" + hotel['hotel'] + "</a>\n" +
                            "<p class='description'>" + (hotel['description'].length > 300 ? (hotel['description'].substring(0, 300) + "...") : hotel['description']) + "</p>\n" +
                            "<div class='info-container'><div class='nutrition-container'><img class='image-nutrition' src='../images/nutrition.png'><p class='info-nutrition'>" + hotel['nutrition'] + "</p></div><p class='price'>" + hotel['price'] + " грн</p></div>" +
                            "</div>" +
                            "</div>");
                })
                    ;
                }
            });
        }
    </script>
<?php
$hotels = getHotels($_GET['state'], $_GET['country'], $_GET['hot'], $_GET['nutrition']);
$result = array();
$i = 0;
while ($row = mysqli_fetch_array($hotels)) {
    $result[$i] = $row;
    $result[$i]['photos'] = array();
    $photos = getPhotos($row['id']);
    $j = 0;
    while ($photo = mysqli_fetch_array($photos)) {
        $result[$i]['photos'][$j] = $photo;
        $j++;
    }
    $i++;
}
for ($i = 0; $i < sizeof($result); $i++) {
    showHotel($result[$i]);
}
echo "</div>";
echo "<div id='loadMore' style='display:flex;justify-content: center;'><button onclick='onLoadMore()' class='button-more btn btn-outline-warning'>ЕЩЕ</button></div>";


//вывести отель на экран
function showHotel($hotel)
{
    echo "<div class='list-item'>
	<img src='../images/uploads/" . $hotel['photos'][0]['path'] . "' style='min-width:200px;width:200px;height:133px;align-self:center'>
	<div style='margin-left:10px;margin-top:5px;margin-right:10px; width:100%;'>
	<a href='/index.php?page=hotel&id=" . $hotel['id'] . "' class='title'>" . $hotel['hotel'] . "</a>
	<p class='description'>" . (mb_strlen($hotel['description']) > 300 ? (mb_substr($hotel['description'], 0, 300, 'UTF-8') . "...") : $hotel['description']) . "</p>
	<div class='info-container'><div class='nutrition-container'><img class='image-nutrition' src='../images/nutrition.png'><p class='info-nutrition'>" . $hotel['nutrition'] . "</p></div><p class='price'>" . $hotel['price'] . " грн</p></div>
	</div>
	</div>";
}