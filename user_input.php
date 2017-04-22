<?php
echo '<div class="input">';
echo '    <div style="color: red; width: 300px; auto; position: relative; left: 350px; top: 100px">SHIFT+ENTER VAHETAB RIDA OKEI?</div>';
if (isset($_SESSION['login_user'])){
    echo '    <form method="post" action="send_data.php" id="insert_form" onsubmit="return checkFormNoUser(this);">';
}
else {
    echo '    <form method="post" action="send_data.php" id="insert_form" onsubmit="return checkForm(this);">';
}
if (!isset($_SESSION['login_user'])){
    echo '<input type="text" name="user" placeholder="Sisesta kasutaja" required/>';
}
echo '        <textarea id="txtArea" name="comment" form="insert_form" placeholder="Sisesta tekst" onkeydown="pressed(event)" required></textarea>';
echo '        <input id="submit_button" type="submit" value="Post"/>';
echo '    </form>';
echo '</div>';
?>