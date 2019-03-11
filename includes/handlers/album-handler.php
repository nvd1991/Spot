<?php
//album-handler.php
//****************************************************define functions *************************************************

/**
 * Echo all songs info into unordered list
 *
 * @param $album
 */
function echo_songs($album){
    $songs = $album->getSongs();
    $index = 1;
    foreach ($songs as $song){
        echo_song($index, $song->getTitle(), $song->getArtist()->getName(), $song->getDuration());
        $index++;
    }
}

/**
 * Echo out song's info into unordered list
 *
 * @param $title
 */
function echo_song($index, $title, $artist, $duration){
    echo "
            <li class='trackListRow'>
                <div class='trackCount'>
                    <img class='play' src='assets/images/icons/play-white.png' alt='Play'>
                    <span class='trackNumber'>$index</span>
                </div>
                <div class='trackInfo'>
                    <span class='trackName'>$title</span>
                    <span class='artistName'>$artist</span>
                </div>
                <div class='trackOptions'>
                    <img class='optionsButton' src='assets/images/icons/more.png' alt='More'>
                </div>
                <div class='trackDuration'>
                    <span class='duration'>$duration</span>
                </div>
            </li>
            ";
}

//****************************************************define functions end**********************************************

//****************************************************Handler start*****************************************************
if(isset($_GET['id'])){
    $albumId = $_GET['id'];
} else {
    header('Location: index.php');
}

$album = new Album($connection);
$album->load($albumId);

//****************************************************Handler end*******************************************************