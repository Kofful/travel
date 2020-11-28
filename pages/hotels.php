<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div style='background-color: rgba(173, 216, 230, 0.2); width:100%'>
    <form action="index.php?page=hotels" method="get">
        <input name="page" value="hotels" style='display:none;'>
        <script>
            function onChangeCountry(country) {
                $.post('functions.php', {get_states: 0, country: country.value}, function (data) {
                    let states = $('#states')[0].options;
                    for (let i = states.length; i > 0; i--) {
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
        <div class="form-container">
            <div class="form-search">
                <input type="text" class="form-control" placeholder="Название отеля" id="name" name="name"
                        onchange="onChangeCountry(this)" value="<?php
                echo isset($_GET['name']) ? $_GET['name'] : "";
                ?>"/>
            </div>
            <div class="form-div">
                <select class="custom-select none-outline" style='width:200px;' id="countries" name="country"
                        onchange="onChangeCountry(this)">
                    <option value="0">Все страны</option>
                    <?php
                    $countries = getCountries();
                    while ($row = mysqli_fetch_array($countries)) {
                        echo "<option value='" . $row['id'] . ($row['id'] == $_GET['country'] ? "'selected>" : "'>") . $row['country'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-div">
                <select class="custom-select none-outline" style='width:200px;' id="states" name="state">
                    <option value="0">Все города</option>
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
        </div>
        <button style='margin:10px;' type="submit" class='btn btn-primary'>Поиск</button>
    </form>
</div>
<div id="hotel-container">
    <script>
        let page = 1;

        function onLoadMore() {
            $("#hotel-container").append("<div id=\"loader\" style=\"display: flex; justify-content: center;\"><div class=\"loader\"></div></div>");
            let country = $("#countries")[0].value;
            let state = $("#states")[0].value;
            let name = $("#name")[0].value;
            $.post('functions.php', {
                search_hotels: 0,
                country,
                state,
                name,
                page
            }, function (data) {
                page++;
                data = JSON.parse(data);
                let hotels = $('#hotel-container');
                $('#loader')[0].remove();
                if (data == null) {
                    $("#loadMore").remove();
                } else {
                    if (data.length < 10) {
                        $("#loadMore").remove();
                    }
                    data.forEach(function (hotel) {
                        hotels.append("<div class='list-item'>\n" +
                            "<img src='../images/uploads/" + hotel["path"] + "' style='min-width:200px;width:200px;height:133px;align-self:center'>" +
                            "<div style='margin-left:10px;margin-top:5px;margin-right:10px; width:100%;'>" +
                            "<a href='/index.php?page=hotel&id=" + hotel['id'] + "' class='title'>" + hotel['hotel'] + "</a>\n" +
                            "<p class='description'>" + (hotel['description'].length > 300 ? (hotel['description'].substring(0, 300) + "...") : hotel['description']) + "</p>\n" +
                            "</div>" +
                            "</div>");
                    })
                    ;
                }
            });
        }
    </script>
<?php
//формирование запроса отелей
$request = array();
$request['country'] = $_GET['country'];
$request['state'] = $_GET['state'];
$request['name'] = $_GET['name'];
$hotels = getHotels($request);
$result = array();
$i = 0;
while ($row = mysqli_fetch_array($hotels)) {
    $result[$i] = $row;
    $i++;
}
for ($i = 0; $i < sizeof($result); $i++) {
    showHotel($result[$i]);
}
echo "</div>";
if (count($result) == 10)
    echo "<div id='loadMore' style='display:flex;justify-content: center;'><button onclick='onLoadMore()' class='button-more btn btn-outline-warning'>ЕЩЕ</button></div>";


//вывести отель на экран
function showHotel($hotel)
{
    echo "<div class='list-item'>
	<img src='../images/uploads/" . $hotel['path'] . "' style='min-width:200px;width:200px;height:133px;align-self:center'>
	<div style='margin-left:10px;margin-top:5px;margin-right:10px; width:100%;'>
	<a href='/index.php?page=hotel&id=" . $hotel['id'] . "' class='title'>" . $hotel['hotel'] . "</a>
	<p class='description'>" . (mb_strlen($hotel['description']) > 300 ? strip_tags(mb_substr($hotel['description'], 0, 300, 'UTF-8') . "...") : strip_tags($hotel['description'])) . "</p>
	</div>
	</div>";
}