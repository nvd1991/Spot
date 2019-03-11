<?php
//updateSongPlays.php
include '../../config.php';
include '../../classes/Artist.php';
include '../../classes/Album.php';
include '../../classes/Song.php';
//****************************************************define functions *************************************************


//****************************************************define functions end**********************************************

//****************************************************Handler start*****************************************************
if(isset($_POST['songId'])){
    $song = new Song($connection);
    if($song->load($_POST['songId'])){
        $song->update_plays();
    }
}

//****************************************************Handler end*******************************************************