<div class="pildid">
    <?php
    foreach ($files as $oneFile) {
        echo '<div class="smallPic">';
        echo '<img src="'.htmlspecialchars($oneFile).'" width="200" height="200" class="pic" alt="small picture"/>';
        echo '</div>';
    }
    ?>
</div>