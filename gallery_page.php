<div class="pildid">
    <div class="bigPic">
        <img src="" id="bigPicInside"/>
    </div>
    <?php
    foreach ($files as $oneFile) {
        echo '<div class="smallPic">';
        echo '<img src="'.$oneFile.'" width="200" height="200" class="pic"/>';
        echo '</div>';
    }
    ?>
</div>