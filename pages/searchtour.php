
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div style='background-color: rgba(173, 216, 230, 0.2); width:100%'>
    <form action="index.php?page=searchtour" method="get">
        <input name="page" value="searchtour" style='display:none;'>
        <input id="hot" name="hot" value="<?php echo ($_GET['hot'] == 1) ? 1 : 0 ?>"
               style='display:none'>
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
        <div class="form-container">
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
            <div class="form-div">
                <select class="custom-select none-outline" style='width:200px;' id="nutrition" name="nutrition">
                    <option value="0">Любой тип питания</option>
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
            <div class="form-div">
                <select class="custom-select none-outline" style='width:200px;' id="room-type" name="room-type">
                    <option value="0">Любой тип номера</option>
                    <?php
                    $room_types = [
                        "1" => "Apartment",
                        "2" => "De Luxe",
                        "3" => "Duplex",
                        "4" => "Studio",
                        "5" => "Standart",
                        "6" => "Residense",
                        "7" => "Villa"];
                    $i = 1;
                    while ($i < 8) {
                        echo "<option value='" . $i . ($i == $_GET['room-type'] ? "'selected>" : "'>") . $room_types[$i] . "</option>";
                        $i++;
                    }
                    ?>
                </select>
            </div>
            <script>
                let i = 0;

                function onHeadsDown() {
                    let dropdownheads = $('#dropdownheads');
                    if (dropdownheads.css('height') === '0px') {
                        i = 1;
                    }
                }

                function onHeadsClick() {
                    if (i === 0) {
                        $('#dropdownheads-button').blur();
                    } else i = 0;
                }

                function onAdultsClick(element) {
                    let countdiv = $("#adults-count");
                    let count = parseInt(countdiv.text());
                    if (element === '+') {
                        if (count === 1) {
                            $("#adults-minus").removeClass("inactive");
                        }
                        if (count === 19) {
                            $("#adults-plus").addClass("inactive");
                        }
                        if (count < 20)
                            countdiv.text(++count);
                    } else {
                        if (count === 2) {
                            $("#adults-minus").addClass("inactive");
                        }
                        if (count === 20) {
                            $("#adults-plus").removeClass("inactive");
                        }
                        if (count > 1)
                            countdiv.text(--count);
                    }
                    $("#adults").attr("value", count);
                }

                function onChildrenClick(element) {
                    let countdiv = $("#children-count");
                    let count = parseInt(countdiv.text());
                    if (element === '+') {
                        if (count === 0) {
                            $("#children-minus").removeClass("inactive");
                        }
                        if (count === 9) {
                            $("#children-plus").addClass("inactive");
                        }
                        if (count < 10) {
                            $("#children-container").append("<select class='custom-select none-outline' style='margin: 5px;width: 120px;' name='child" + ++count + "'>" +
                                "<option value='0'>до года</option>" +
                                "<option value='1'>1 год</option>" +
                                "<option value='2'>2 года</option>" +
                                "<option value='3'>3 года</option>" +
                                "<option value='4'>4 года</option>" +
                                "<option value='5'>5 лет</option>" +
                                "<option value='6'>6 лет</option>" +
                                "<option value='7'>7 лет</option>" +
                                "<option value='8'>8 лет</option>" +
                                "<option value='9'>9 лет</option>" +
                                "<option value='10'>10 лет</option>" +
                                "<option value='11'>11 лет</option>" +
                                "<option value='12'>12 лет</option>" +
                                "<option value='13'>13 лет</option>" +
                                "<option value='14'>14 лет</option>" +
                                "<option value='15'>15 лет</option>" +
                                "<option value='16'>16 лет</option>" +
                                "<option value='17'>17 лет</option>" +
                                "</select>");
                            countdiv.text(count);
                        }
                    } else {
                        if (count === 1) {
                            $("#children-minus").addClass("inactive");
                        }
                        if (count === 10) {
                            $("#children-plus").removeClass("inactive");
                        }
                        if (count > 0) {
                            $("#children-container select").last().remove();
                            countdiv.text(--count);
                        }
                    }
                    $("#children").attr("value", count);
                }
            </script>
            <div tabindex="0" id="dropdownheads-container" class="form-div">
                <button id="dropdownheads-button" type="button" onmousedown="onHeadsDown()" onclick="onHeadsClick()"
                        class="btn none-outline dropdownheads custom-select">Кто поедет
                </button>
                <div id="dropdownheads">
                    <h6>Взрослые:</h6>
                    <div class="adults-container">
                        <input id="adults" name="adults"
                               value="<?php echo isset($_GET['adults']) ? $_GET['adults'] : 2 ?>" style='display:none;'>
                        <div id="adults-minus" onclick="onAdultsClick('-')"
                             class="adults-change <?php if (isset($_GET['adults']) && $_GET['adults'] === '1') echo "inactive"; ?>">
                            -
                        </div>
                        <div id="adults-count"> <?php echo (!isset($_GET['adults']) || $_GET['adults'] == 2) ? '2' : $_GET['adults'] ?></div>
                        <div id="adults-plus" onclick="onAdultsClick('+')"
                             class="adults-change" <?php if (isset($_GET['adults']) && $_GET['adults'] === '20') echo "inactive"; ?>>
                            +
                        </div>
                    </div>
                    <h6>Дети:</h6>
                    <div class="children-container">
                        <input id="children" name="children"
                               value="<?php echo isset($_GET['children']) ? $_GET['children'] : 0 ?>"
                               style='display:none;'>
                        <div id="children-minus" onclick="onChildrenClick('-')"
                             class="children-change <?php if (!isset($_GET['children']) || $_GET['children'] === '0') echo "inactive"; ?>">
                            -
                        </div>
                        <div id="children-count"> <?php echo (!isset($_GET['children']) || $_GET['children'] == 0) ? '0' : $_GET['children'] ?></div>
                        <div id="children-plus" onclick="onChildrenClick('+')"
                             class="children-change <?php if (isset($_GET['children']) && $_GET['children'] === '10') echo "inactive"; ?>">
                            +
                        </div>
                    </div>
                    <div id="children-container">
                        <?php if (isset($_GET['children']) && $_GET['children'] > 0) {
                            $i = 1;
                            while (isset($_GET['child' . $i])) {
                                $age = $_GET['child' . $i];
                                echo "<select class='custom-select none-outline' style='margin: 5px;width: 120px;' name='child" . $i . "' id='child" . $i . "'>";
                                for ($value = 0; $value < 18; $value++) {
                                    if ($value == 0) {
                                        echo "<option value='0' " . ($age == 0 ? 'selected' : '') . ">до года</option>";
                                    } else if ($value == 1) {
                                        echo "<option value='1' " . ($age == 1 ? 'selected' : '') . ">1 год</option>";
                                    } else if ($value > 1 && $value < 5) {
                                        echo "<option value='$value' " . ($age == $value ? 'selected' : '') . ">$value года</option>";
                                    } else if ($value > 4) {
                                        echo "<option value='$value' " . ($age == $value ? 'selected' : '') . ">$value лет</option>";
                                    }
                                }
                                echo "</select>";
                                $i++;
                            }
                        } ?>
                    </div>
                </div>
            </div>
            <div class="daterange-div">
                <input id="daterange" class="custom-select" type="text" name="daterange"
                       value="<? echo isset($_GET['daterange']) ? $_GET['daterange'] : (date("Y.m.d") . " - " . date("Y.m.d", strtotime(date("m/d/Y") . "+5 days"))) ?>"/>
            </div>
            <script>
                $(function () {
                    $('input[name="daterange"]').daterangepicker({
                        opens: 'center',
                        maxSpan: {
                            days: 21
                        },
                        minDate: moment().format("YYYY.MM.DD"),
                        showCustomRangeLabel: false,
                        startOfWeek: 'monday',
                        locale: {
                            format: "YYYY.MM.DD",
                            separator: " - ",
                            applyLabel: "Подтвердить",
                            cancelLabel: "Отмена",
                            fromLabel: "С",
                            toLabel: "По",
                            customRangeLabel: "Custom",
                            weekLabel: "W",
                            daysOfWeek: [
                                "Вс",
                                "Пн",
                                "Вт",
                                "Ср",
                                "Чт",
                                "Пт",
                                "Сб",
                            ],
                            monthNames: [
                                "Январь",
                                "Февраль",
                                "Март",
                                "Апрель",
                                "Май",
                                "Июнь",
                                "Июль",
                                "Август",
                                "Сентябрь",
                                "Октябрь",
                                "Ноябрь",
                                "Декабрь"
                            ],
                            firstDay: 1,
                        }
                    }, function (start, end, label) {
                    });
                });
            </script>
            <script>
                let url_string = window.location.href;
                let url = new URL(url_string);
                let range = url.searchParams.get("pricerange");
                let min_price = 0;
                let max_price = 100000;
                if (range) {
                    min_price = range.split(" ")[0];
                    max_price = range.split(" ")[2];
                }
                $(function () {
                    $("#pricerange").slider({
                        range: true,
                        min: 0,
                        max: 100000,
                        step: 100,
                        values: [min_price, max_price],
                        slide: function (event, ui) {
                            $("#amount").val(ui.values[0] + " - " + ui.values[1]);
                        }
                    });
                });
            </script>
            <div class="pricerange-div">
                <p>
                    <label for="amount">Цена:</label>
                    <input type="text" id="amount" name="pricerange" readonly
                           style="border:0; margin-left: 5px; color:#f6931f; font-weight:bold;"
                           value="<? echo isset($_GET['pricerange']) ? $_GET['pricerange'] : "0 - 100000" ?>">
                </p>
                <div id="pricerange"></div>
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
            let hot = $("#hot")[0].value;
            let nutrition = $("#nutrition")[0].value;
            let room_type = $("#room-type")[0].value;
            let adults = $("#adults")[0].value;
            let children = $("#children")[0].value;
            let child_ages = [];
            for (let i = 0; i < children; i++) {
                child_ages.push($("#child" + (i + 1))[0].value);
            }
            let daterange = $("#daterange")[0].value;
            let pricerange = $("#pricerange")[0].value;
            $.post('functions.php', {
                get_hotels: 0,
                country,
                state,
                hot,
                nutrition,
                room_type,
                adults,
                children,
                child_ages,
                daterange,
                pricerange,
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
                            "<a href='/index.php?page=hotel&id="+ hotel['hotel_id'] + "&room_id="+ hotel['id'] + "&daterange=" + daterange + "' class='title'>" + hotel['hotel'] + "</a>\n" +
                            "<p class='description'>" + (hotel['description'].length > 300 ? (hotel['description'].substring(0, 300) + "...") : hotel['description']) + "</p>\n" +
                            "<div class='info-container'>" +
                            "<div class='nutrition-container'><img class='image-nutrition' src='../images/nutrition.png'><p class='info-nutrition'>" + hotel['nutrition'] + "</p></div>" +
                            "<div class='roomtype-container'><img class='image-roomtype' src='../images/room.png'><p class='info-roomtype'>" + hotel['room_type'] + "</p></div>" +
                            "<div class='places-container'><img class='image-places' src='../images/places.png'><p class='info-places'>x" + hotel['places'] + "</p></div>" +
                            "<p class='price'>" + Math.round(hotel['price']) + " грн</p>" +
                            "</div>" +
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
$request['nutrition'] = $_GET['nutrition'];
$request['room-type'] = $_GET['room-type'];
$request['adults'] = isset($_GET['adults']) ? $_GET['adults'] : 2;
if (isset($_GET['children'])) {
    $request['children'] = $_GET['children'];
    $request['child-ages'] = array();
    for ($i = 1; $i <= $_GET['children']; $i++) {
        $request["child-ages"][$i - 1] = $_GET["child{$i}"];
    }
}
$request['daterange'] = isset($_GET['daterange']) ? $_GET['daterange'] : (date("Y.m.d") . " - " . date("Y.m.d", strtotime(date("m/d/Y") . "+5 days")));
;
$request['pricerange'] = $_GET['pricerange'];
$hotels = getTours($request, $_GET['hot']);
$result = array();
$i = 0;
while ($row = mysqli_fetch_array($hotels)) {
    $result[$i] = $row;
    $i++;
}
for ($i = 0; $i < sizeof($result); $i++) {
    showHotel($result[$i], $request['daterange']);
}
echo "</div>";
if (count($result) == 10)
    echo "<div id='loadMore' style='display:flex;justify-content: center;'><button onclick='onLoadMore()' class='button-more btn btn-outline-warning'>ЕЩЕ</button></div>";


//вывести отель на экран
function showHotel($hotel, $daterange)
{
    echo "<div class='list-item'>
	<img src='../images/uploads/" . $hotel['path'] . "' style='min-width:200px;width:200px;height:133px;align-self:center'>
	<div style='margin-left:10px;margin-top:5px;margin-right:10px; width:100%;'>
	<a href='/index.php?page=hotel&id=". $hotel['hotel_id'] . "&room_id=" . $hotel['id'] . "&daterange=" . $daterange . "' class='title'>" . $hotel['hotel'] . "</a>
	<p class='description'>" . (mb_strlen($hotel['description']) > 300 ? (mb_substr($hotel['description'], 0, 300, 'UTF-8') . "...") : $hotel['description']) . "</p>
	<div class='info-container'>
	<div class='nutrition-container'><img class='image-nutrition' src='../images/nutrition.png'><p class='info-nutrition'>" . $hotel['nutrition'] . "</p></div>
	<div class='roomtype-container'><img class='image-roomtype' src='../images/room.png'><p class='info-roomtype'>" . $hotel['room_type'] . "</p></div>
	<div class='places-container'><img class='image-places' src='../images/places.png'><p class='info-places'>x" . $hotel['places'] ."</p></div>

	<p class='price'>" . round($hotel['price']) . " грн</p>
	</div>
	</div>
	</div>";
}