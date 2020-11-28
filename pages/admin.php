<?php
if ($_SESSION['permit'] != 'admin') {
    echo "<script>window.location.href='/'</script>";
    exit();
}
?>
<div class="admin-container">
    <form action="index.php?page=admin" method="post"
          class="admin-form">
        <h5>Добавить страну</h5>
        <input type="text" name="country" class="form-control">
        <button type="submit" class="btn btn-primary form-control" name="btn_country">Добавить</button>
    </form>

    <form action="index.php?page=admin" method="post" class="admin-form">
        <h5>Удалить страну</h5>
        <select name="country" class="form-control none-outline">
            <option value='0'>Выбрать страну</option>
            <?php
            $countries = getCountries();
            while ($row = mysqli_fetch_array($countries)) {
                echo "<option value='" . $row['id'] . "'>" . $row['country'] . "</option>";
            }
            ?>
        </select>
        <button type="submit" class="btn btn-danger form-control" name="btn_country_del">Удалить</button>
    </form>
    <form action="index.php?page=admin" method="post"
          class="admin-form">
        <h5>Добавить город</h5>
        <select name="country" class="form-control none-outline">
            <option value='0'>Выбрать страну</option>
            <?php
            $countries = getCountries();
            while ($row = mysqli_fetch_array($countries)) {
                echo "<option value='" . $row['id'] . "'>" . $row['country'] . "</option>";
            }
            ?>
        </select>
        <input type="text" name="state" class="form-control">
        <button type="submit" class="btn btn-primary form-control" name="btn_state">Добавить</button>
    </form>

    <form action="index.php?page=admin" method="post"
          class="admin-form">
        <h5>Удалить город</h5>
        <select name="country" class="form-control none-outline" onchange="onChangeCountry(this)">
            <option value='0'>Выбрать страну</option>
            <?php
            $countries = getCountries();
            while ($row = mysqli_fetch_array($countries)) {
                echo "<option value='" . $row['id'] . "'>" . $row['country'] . "</option>";
            }
            ?>
        </select>
        <select id="states" name="state" class="form-control none-outline">
            <option value='0'>Выбрать город</option>
            ;
            <?php
            if (isset($_POST['states'])) {
                while ($row = mysqli_fetch_array($_POST['states'])) {
                    echo "<option value='" . $row['id'] . "'>" . $row['state'] . "</option>";
                }
            }
            ?>
        </select>
        <button type="submit" class="btn btn-danger form-control" name="btn_state_del">Удалить</button>
    </form>
</div>

<form id="hotel-adding-form" enctype="multipart/form-data" action="index.php?page=admin" method="post"
      style="background-color:white;box-shadow:0 0 2px 2px rgba(0,0,0,0.1); margin:10px; padding:10px;">
    <h3>Добавить отель</h3>
    <div class="form-group">
        <label>Страна</label>
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
                    )
                    ;
                });
            }

            function onChangeCountryForNewHotel(country) {
                $.post('functions.php', {get_states: 0, country: country.value}, function (data) {
                    let states = $('#new-hotel-states')[0].options;
                    for (i = states.length; i > 0; i--) {
                        states[i] = null;
                    }
                    data = JSON.parse(data);
                    states = $('#new-hotel-states');
                    data.forEach(function (state) {
                            states.append("<option value='" + state['id'] + "'>" + state['state'] + "</option>")
                        }
                    )
                    ;
                });
            }
        </script>
        <select id='countries' name="country" class="form-control" onchange="onChangeCountryForNewHotel(this)">
            <option value='0'>Выбрать страну</option>
            <?php
            $countries = getCountries();
            while ($row = mysqli_fetch_array($countries)) {
                echo "<option value='" . $row['id'] . ($row['id'] == $_POST['country'] ? "'selected>" : "'>") . $row['country'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="new-hotel-states">Город</label>
        <select id="new-hotel-states" name="state" class="form-control" required>
            <option value='0'>Выбрать город</option>
        </select>
    </div>
    <div class="form-group">
        <label for="hotel-input">Название:</label>
        <input id="hotel-input" type="text" name="hotel" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="min_age-input">Минимальный возраст:</label>
        <input id="min_age-input" type="number" name="min_age" class="form-control" min="0" max="18" required>
    </div>
    <div class="form-group">
        <label for="nutrition-input">Питание:</label>
        <select id="nutrition-input" name="nutrition" class="form-control none-outline">
            <option value='0'>Выбрать тип питания</option>
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
    <div class="form-group">
        <input id="checkbox-hot" type="checkbox" class="custom-checkbox" name="hot">
        <label for="checkbox-hot">Сохранить как горящий тур</label>
    </div>
    <div class="form-group">
        <label for="description-editor">Описание:</label>
        <textarea name="description" id="description-editor" rows="10" cols="80"></textarea>
    </div>
    <script>
        CKEDITOR.replace('description-editor');
    </script>
    <label id="upload-images-button" class="btn btn-info" for="add-images">Загрузить картинки</label>
    <input id="add-images" accept="image/*" type="file" name="image[]" multiple><br>
    <div id="adminCarousel" class="carousel slide" data-ride="carousel"
         style="height:0px; width:600px;overflow: hidden;">
        <div class="carousel-inner">

        </div>
        <a class="carousel-control-prev" href="#adminCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#adminCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <script>
        $("#add-images").change(
            function () {
                sendAjaxForm();
            }
        );

        function sendAjaxForm() {
            let data = new FormData();
            $.each($("#add-images")[0].files, function (key, value) {
                data.append(key, value);
            });
            $("#adminCarousel").height("400px");
            $('.carousel-inner').empty();
            $.ajax({
                url: "createhotel.php",
                type: "POST",
                dataType: "text",
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    let result = response.split(" ");
                    if (result.length === 1) {
                        $("#adminCarousel").height("0");
                    } else {
                        for (let i = 0; i < result.length - 1; i++) {
                            $('.carousel-inner').append("<div style='transition: 200ms !important;' class='carousel-item" + (i === 0 ? " active" : "") + "'><img style='object-fit: cover; width: 600px; height:400px;' src='data:image/png;base64," + result[i] + "'></div>");
                        }
                    }
                },
                error: function () {
                }
            });
        }</script>
    <div id="admin-add-hotel">
        <button id="btn_add-hotel" type="submit" class="btn btn-primary" name="btn_hotel">Добавить</button>
    </div>
</form>

<!--TODO relocate logic to hotel page-->
<form action="index.php?page=admin" method="post"
      style="background-color:white;box-shadow:0 0 2px 2px rgba(0,0,0,0.1); margin:10px; padding:10px;">
    <label>Удалить отель:</label><br>
    <label>Страна</label>
    <script>
        function onChangeCountry1(country) {
            $.post('functions.php', {get_states: 0, country: country.value}, function (data) {
                let states = $('#states2')[0].options;
                for (i = states.length; i > 0; i--) {
                    states[i] = null;
                }
                data = JSON.parse(data);
                states = $('#states2');
                data.forEach(function (state) {
                        states.append("<option value='" + state['id'] + "'>" + state['state'] + "</option>")
                    }
                )
                ;
            });
        }
    </script>
    <select id='countries1' name="country" onchange="onChangeCountry1(this)">
        <option value='0'>Выбрать страну</option>
        ;
        <?php
        $countries = getCountries();
        while ($row = mysqli_fetch_array($countries)) {
            echo "<option value='" . $row['id'] . ($row['id'] == $_POST['country'] ? "'selected>" : "'>") . $row['country'] . "</option>";
        }
        ?>
    </select><br>
    <label>Город</label>
    <script>
        function onChangeState(state) {
            $.post('functions.php', {
                get_hotels: 0,
                state: state.value,
                country: $('#countries')[0]['value']
            }, function (data) {
                let hotels = $('#hotels')[0].options;
                for (i = hotels.length; i > 0; i--) {
                    hotels[i] = null;
                }
                data = JSON.parse(data);
                hotels = $('#hotels');
                data.forEach(function (hotel) {
                    console.log(hotel);
                    hotels.append("<option value='" + hotel['id'] + "'>" + hotel['hotel'] + "</option>")
                })
                ;
            });
        }
    </script>
    <select id="states2" name="state" onchange="onChangeState(this)">
        <option value='0'>Выбрать город</option>
        ;
        <?php
        if (isset($_POST['states1'])) {
            while ($row = mysqli_fetch_array($_POST['states1'])) {
                echo "<option value='" . $row['id'] . ($row['id'] == $_POST['state'] ? "'selected>" : "'>") . $row['state'] . "</option>";
            }
        }
        ?>
    </select><br>
    <label>Отель:</label>
    <select id="hotels" name="hotel">
        <?php
        if (isset($_POST['hotels'])) {
            while ($row = mysqli_fetch_array($_POST['hotels'])) {
                echo "<option value='" . $row['id'] . "'>" . $row['hotel'] . "</option>";
            }
        }
        ?>
    </select>
    <button type="submit" class="btn btn-danger" name="btn_hotel_del">Удалить отель</button>
</form>
