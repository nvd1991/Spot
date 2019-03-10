<!--album.php-->
<?php
include 'includes/header.php';
include 'includes/classes/Artist.php';
include 'includes/classes/Album.php';
include 'includes/classes/Song.php';
?>
    <!--main content-->
    <?php include 'includes/handlers/album-handler.php'; ?>
    <div class="entityInfo">
        <div class="leftSection">
            <img src="<?php echo $album->getArtworkPath(); ?>" alt="Artwork">
        </div>
        <div class="rightSection">
            <h2><?php echo $album->getTitle(); ?></h2>
            <p>By <?php echo $album->getArtist()->getName(); ?></p>
            <p><?php echo $album->getNumberOfSongs(); ?> songs</p>
        </div>
    </div>

    <div class="trackListContainer">
        <ul class="trackList">
            <?php echo_songs($album); ?>
        </ul>
    </div>
<?php include 'includes/footer.php' ?>


