<?php
//getSongJson.php
include '../../config.php';
include '../../classes/Artist.php';
include '../../classes/Album.php';
include '../../classes/Song.php';
//****************************************************define functions *************************************************
/**
 * Retrieve basic song info into an array, update plays property on success
 *
 * @param $connection
 * @param $songId
 * @return array|bool array of song's info or false on failure
 */
function get_song_info_array($connection, $songId){
    $song = new Song($connection);
    if($song->load($songId)){
        $songInfoArray = [];
        $columns = ['Id', 'Title', 'Artist', 'Album', 'Genre', 'Duration', 'Path', 'Plays', 'AlbumOrder'];
        foreach ($columns as $column){
            $method = "get$column";
            $songInfoArray[$column] = $song->$method();
        }
        $songInfoArray['Artist'] = $songInfoArray['Artist']->getName();
        $songInfoArray['Album'] = ['Title' => $songInfoArray['Album']->getTitle(),
            'ArtworkPath' => $songInfoArray['Album']->getArtworkPath()];
        return $songInfoArray;
    }
    return false;
}

//****************************************************define functions end**********************************************

//****************************************************Handler start*****************************************************
if(isset($_POST['songId'])){
    if($songInfoArray = get_song_info_array($connection, $_POST['songId'])){
        echo json_encode($songInfoArray);
    }
}

//****************************************************Handler end*******************************************************