<?php
//Album.php class
class Album {
    private $id;
    private $title;
    private $artist;
    private $genre;
    private $artwork_path;
    private $connection;

    /**
     * Album constructor.
     * @param $connection
     */
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /**
     * Album's id getter
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Album's title getter
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Album's artist getter
     * Return an artist object on success, else return false
     *
     * @return Artist
     */
    public function getArtist()
    {
        $artist = new Artist($this->connection);
        if($artist->load($this->artist))
            return $artist;
        return false;
    }

    /**
     * Album's genre getter
     *
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Album's artwork path getter
     *
     * @return mixed
     */
    public function getArtworkPath()
    {
        return $this->artwork_path;
    }

    /**
     * Albums's number of songs getter
     *
     * @return int
     */
    public function getNumberOfSongs(){
        $albumId = $this->id;
        $sql = "SELECT count(id) as count from songs where album = $albumId";
        $result = mysqli_query($this->connection, $sql);
        if(mysqli_num_rows($result)){
            return (mysqli_fetch_assoc($result))['count'];
        }
        return 0;
    }

    /**
     * Album's songs getter
     *
     * @return Song[]|null an array of songs or null if nothing is found
     */
    public function getSongs(){
        $albumId = $this->id;
        $sql = "SELECT id from songs where album = $albumId order by album_order asc";
        $result = mysqli_query($this->connection, $sql);
        if(mysqli_num_rows($result)){
            $songs = [];
            while($row = mysqli_fetch_assoc($result)){
                $song = new Song($this->connection);
                $song->load($row['id']);
                array_push($songs, $song);
            }
            return $songs;
        }
        return null;
    }

    /**
     * Load album info into this album object given album id
     *
     * @param $albumId
     * @return bool
     */
    public function load($albumId){
        if($album = $this->get_album($albumId)){
            foreach ($album as $columnName => $columnValue){
                $this->$columnName = $columnValue;
            }
            return true;
        }
        return false;
    }

    /**
     * Get album info from DB given album id
     *
     * @param $albumId
     * @return array|bool|null
     */
    private function get_album($albumId){
        $sql = "select id, title, artist, genre, artwork_path from albums where id = $albumId";
        $result = mysqli_query($this->connection, $sql);
        if(mysqli_num_rows($result)){
            return mysqli_fetch_assoc($result);
        }
        return false;
    }
}