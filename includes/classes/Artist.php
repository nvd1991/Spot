<?php
//Artist.php class
class Artist {
    private $id;
    private $name;
    private $connection;

    /**
     * Artist constructor.
     * @param $connection
     */
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /**
     * Artist's name getter
     *
     * @return mixed
     */
    public function getName(){
        return $this->name;
    }

    /**
     * Load artist info into this artist object given artist id
     *
     * @param $artistId
     * @return bool
     */
    public function load($artistId){
        if($artist =  $this->get_artist($artistId)){
            $this->id = $artistId;
            $this->name = $artist['name'];
            return true;
        }
        return false;
    }

    /**
     * Get artist info from DB given artist id
     *
     * @param $artistId
     * @return array|bool|null
     */
    private function get_artist($artistId){
        $sql = "select name from artists where id=$artistId";
        $result = mysqli_query($this->connection, $sql);
        if(mysqli_num_rows($result)){
            return mysqli_fetch_assoc($result);
        }
        return false;
    }
}