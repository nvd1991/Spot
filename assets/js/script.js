// script.js
let currentPlaylist = [];
let currentCounterInPlayList = 0;
let albumPlaylist = [];
let audioElement = new Audio();
let isVolumeClick = false;
let isMuted = false;
let isRepeat = false;
let oldPlaylist = [];
let isShuffle = false;
let isAlbumPlaylistSelected = false;

//Audio object
function Audio(){
    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    //When audio loaded completely and browser can start playing the media (when it has buffered enough to begin)
    this.audio.addEventListener('durationchange', function () {
        $('.progressTime.remaining').text(formatTime(this.duration));
    });

    //update current time, remaining time and progressbar as audio current time is updated
    this.audio.addEventListener('timeupdate', function(){
        $('.progressTime.current').text(formatTime(this.currentTime));
        $('.progressTime.remaining').text(formatTime(this.duration - this.currentTime));
        $('.playbackBar .progressBar .progress').width(updateTrackProgressBar(this));
    });

    //Next song when ended
    this.audio.addEventListener('ended', function () {
        setTimeout(function () {
            $('.controlButtons.next').click();
        }, 3000);
    })

    this.setTrack = function(track){
        this.audio.src = track.Path;
        this.currentlyPlaying = track.Id;
    }

    this.play = function(){
        this.audio.play();
    }

    this.pause = function(){
        this.audio.pause();
    }

    this.currentTime = function(){
        return this.audio.currentTime;
    }

    this.setCurrentTimePercentage = function(percentage){
        this.audio.currentTime =  this.audio.duration * percentage / 100;
    }

    this.setVolume = function (volume){
        this.audio.volume = volume;
        console.log(this.audio.volume);
    }

    this.getVolume = function (){
        return this.audio.volume;
    }

    this.muteAudio = function () {
        this.audio.muted = true;
    }

    this.unmuteAudio = function () {
        this.audio.muted = false;
    }

    this.repeatAudio = function () {
        this.audio.loop = true;
    }

    this.unrepeatAudio = function () {
        this.audio.loop = false;
    }
}

//Set track in the list into audio element
function setTrack(currentCounterInPlayList, playlist, audioElement, play){
    //Validate counter and get the corresponding id
    currentCounterInPlayList = validateCurrentCounter(currentCounterInPlayList, playlist.length);
    const trackId = playlist[currentCounterInPlayList];
    //Ajax to get song's info
    getTrackFromServer(trackId, play);
    return currentCounterInPlayList;
}

//Validate counter
function validateCurrentCounter(currentCounterInPlayList, playlistLength){
    //Validate counter and reassign value if it is < 0 or >= array length
    if(currentCounterInPlayList >= playlistLength){
        currentCounterInPlayList = 0;
    }
    if(currentCounterInPlayList < 0){
        currentCounterInPlayList = playlistLength - 1;
    }
    return currentCounterInPlayList;
}

//Return formatted time from seconds to "minute:second"
function formatTime(seconds){
    seconds = Math.round(seconds);
    const minute = Math.floor(seconds/60);
    seconds %= 60;
    return minute.toString() + ':' + (seconds < 10 ? `0${seconds.toString()}` : seconds.toString() );
}

//Return the width of track progress bar as audio is playing in %
function updateTrackProgressBar(audio){
    return Math.round(audio.currentTime/audio.duration*2*100)/2 + '%'
}

//Adjust volume
function adjustVolume(event){
    let percentage = event.offsetX / $('.volumeBar .progressBarBg').width();
    if(percentage >= 0 && percentage <= 1){
        $('.volumeBar .progress').width(percentage * 100 + '%');
        audioElement.setVolume(percentage);
    }
}

//create shuffle playlist and store old playlist
function shuffleCurrentPlaylist(){
    oldPlaylist = currentPlaylist.slice();
    let currentIndex = currentPlaylist.length, randomIndex, tempValue;
    while(currentIndex !== 0){
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;
        tempValue = currentPlaylist[currentIndex];
        currentPlaylist[currentIndex] = currentPlaylist[randomIndex];
        currentPlaylist[randomIndex] = tempValue;
    }
}

//restore old playlist and counter
function unshuffleCurrentPlaylist(){
    const currentId = currentPlaylist[currentCounterInPlayList];
    currentPlaylist = oldPlaylist;
    currentCounterInPlayList = currentPlaylist.indexOf(currentId.toString(10));
}

//get track from server
function getTrackFromServer(trackId, play){
    $.post('includes/handlers/ajax/getSongJson.php',
        {
            songId: trackId
        },
        function (data) {
            const song = JSON.parse(data);
            //Set audio track and titles
            audioElement.setTrack(song);
            $('#nowPlayingLeft .trackName span').text(song.Title);
            $('#nowPlayingLeft .artistName span').text(song.Artist);
            $('#nowPlayingLeft .albumArtwork').attr('src', song.Album.ArtworkPath);
            if(play){
                //Play audio if true
                $('.controlButtons.play').click();
            }
        });
}
