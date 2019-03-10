<?php
//Song.php class
class Song {
    private $id;
    private $title;
    private $artist;
    private $album;
    private $genre;
    private $duration;
    private $path;
    private $plays;
    private $album_order;
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /**
     * Song's id getter
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Song's title getter
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Song's artist getter
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
     * Song's album getter
     * Return an album object on success, else return false
     *
     * @return Album
     */
    public function getAlbum()
    {
        $album = new Album($this->connection);
        if($album->load($this->album))
            return $album;
        return false;
    }

    /**
     * Song's genre getter
     *
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Song's duration getter
     *
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Song's path getter
     *
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Song's plays getter
     *
     * @return mixed
     */
    public function getPlays()
    {
        return $this->plays;
    }

    /**
     * Song's album order getter
     *
     * @return mixed
     */
    public function getAlbumOrder()
    {
        return $this->album_order;
    }

    /**
     * Load song info into this song object given song id
     *
     * @param $songId
     * @return bool
     */
    public function load($songId){
        if($song = $this->get_song($songId)){
            foreach ($song as $columnName => $columnValue){
                $this->$columnName = $columnValue;
            }
            return true;
        }
        return false;
    }

    /**
     * Get song info from DB given song id
     *
     * @param $songId
     * @return array|bool|null
     */
    private function get_song($songId){
        $sql = "select id, title, artist, album, genre, duration, path, plays, album_order from songs where id = $songId";
        $result = mysqli_query($this->connection, $sql);
        if(mysqli_num_rows($result)){
            return mysqli_fetch_assoc($result);
        }
        return false;
    }
}