<!--index-handler.php-->
<?php

//****************************************************define functions *************************************************
/**
 * Retrieve recommended albums
 *
 * @param $connection
 * @return array|bool
 */
function get_recommend_albums($connection){
    $albums = [];
    $sql = "select id, title, artwork_path from albums order by rand() limit 10";
    $result = mysqli_query($connection, $sql);
    if(mysqli_num_rows($result)){
        while($row = mysqli_fetch_assoc($result)){
            array_push($albums, $row);

        }
        return $albums;
    }
    return false;
}

/**
 * Echo albums into grid view container
 *
 * @param $albums
 */
function echo_recommended_albums($albums){
    foreach ($albums as $album){
        echo_album($album['id'], $album['artwork_path'], $album['title']);
    }
}

/**
 * Echo an album in a grid view item
 *
 * @param $id
 * @param $artwork_path
 * @param $title
 */
function echo_album($id, $artwork_path, $title){
    echo "
                    <div class='gridViewItem'>
                        <a href='album.php?id=$id'>
                            <img src='$artwork_path' alt='Artwork'>
                            <div class='gridViewInfo'>
                                $title
                            </div>
                        </a>                        
                    </div>
                    ";
}

//****************************************************define functions end**********************************************

//****************************************************Handler start*****************************************************

$albums = get_recommend_albums($connection);
echo_recommended_albums($albums);

//****************************************************Handler end*******************************************************