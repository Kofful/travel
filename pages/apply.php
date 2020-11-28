<?php
echo "<div action='index.php?page=hotel&id=".$_GET['id']."' method='post' style='box-shadow:0 0 4px 4px rgba(0,0,0,0.1); padding:20px; margin-top:20px;width:500px;height:250px;background-color:white;	
top:0;
bottom:0;
left:0;
right:0;
margin:auto;'>
<div class='form-group'>
<label class='label-success'>Ваша заявка подана на обработку!</label>
<button onclick='history.back()' class='btn btn-success' name='btn_login' style='margin-top:80px;width:100%;'>Вернуться</button></div>";
?>