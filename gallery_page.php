<div class="pildid">
    <?php
    echo '<div class="bigPic">';
    echo '<img src="" id="bigPicInside"/>';
    echo '</div>';

    $directory = "images/";
    $filecount = 0;
    $files = glob($directory . "*");
    foreach ($files as $oneFile) {
        echo '<div class="smallPic">';
        echo '<img src="'.$oneFile.'" width="200" height="200" class="pic"/>';
        echo '</div>';
    }
    ?>
</div>