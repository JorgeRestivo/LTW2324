<?php function print_img_slider($imgs, $img){ ?>
    <div class="media">
        <div class="image-container">
            <img src="../database/userImages/<?= $img ?>" alt="Image" width="100%" height="100%">
        </div>
        <div class="img-slider">
            <?php foreach ($imgs as $img) { ?>
                <img src="../database/userImages/<?= $img['imagePath']; ?>" alt="<?= $img['title']; ?>" width="100%" height="100%">
            <?php } ?>
        </div>
    </div>
<?php } ?>