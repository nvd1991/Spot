<?php
//album-handler.php
//****************************************************define functions *************************************************

/**
 * Echo all songs info into unordered list and return a list of songs'id
 *
 * @param $album
 * @return array list of songs' ids
 */
function echo_songs($album){
    $songs = $album->getSongs();
    $songIds = [];
    $index = 1;
    foreach ($songs as $song){
        echo_song($index, $song->getId(), $song->getTitle(), $song->getArtist()->getName(), $song->getDuration());
        array_push($songIds, $song->getId());
        $index++;
    }
    return $songIds;
}

/**
 * Echo out song's info into unordered list
 *
 * @param $title
 */
function echo_song($index, $id, $title, $artist, $duration){
    echo "
            <li class='trackListRow'>
                <div class='trackCount'>
                    <span class='trackId'>$id</span>
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