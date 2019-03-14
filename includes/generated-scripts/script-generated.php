<!--script-generated.php-->
<script>
    $(document).ready(function () {
        //When play button is clicked
        $('.controlButtons.play').click(function () {
            //Update plays of the current song when current time of audio element is 0
            if(audioElement.currentTime() === 0){
                $.post('includes/handlers/ajax/updateSongPlays.php',
                    {
                        songId: audioElement.currentlyPlaying
                    });
                $('.volumeBar .progress').width((audioElement.getVolume() * 100) + '%');
            }
            //Hide/show and play song
            $(this).hide();
            $('.controlButtons.pause').show();
            audioElement.play();
        });

        //When pause button is clicked
        $('.controlButtons.pause').click(function () {
            //Hide/show and pause song
            $(this).hide();
            $('.controlButtons.play').show();
            audioElement.pause();
        });

        //When next button is clicked
        $('.controlButtons.next').click(function () {
            //Set the next track in the list into audio element
            currentCounterInPlayList = setTrack(++currentCounterInPlayList, currentPlaylist, audioElement, true);
        });

        //When previous button is clicked
        $('.controlButtons.previous').click(function () {
            //Set the previous track in the list into audio element
            currentCounterInPlayList = setTrack(--currentCounterInPlayList, currentPlaylist, audioElement, true);
        });

        //When drag on progress bar the track update it's current time and progress bar, time span update accordingly
        $('.playbackBar .progressBar .progress').mousedown(function (mousedownEvent) {
            mousedownEvent.preventDefault();
            const mouseX = mousedownEvent.offsetX;
            const progressWidth = $(this).width();
            if(mouseX < progressWidth && mouseX > progressWidth - 10){
                document.onmousemove = function(mousemoveEvent){
                    mousedownEvent.preventDefault();
                    const newPercentage = mousemoveEvent.offsetX / $('.playbackBar .progressBarBg').width() * 100;
                    $('.playbackBar .progress').width(newPercentage + '%');
                    audioElement.setCurrentTimePercentage(newPercentage);
                }
                document.onmouseup = function(){
                    document.onmouseup = null;
                    document.onmousemove = null;
                }
            }
        });

        //When click on progressBar background the track update it's current time and progress bar, time span update accordingly
        $('.playbackBar .progressBarBg').mousedown(function(event){
            event.preventDefault();
            const newPercentage = event.offsetX / $(this).width() * 100;
            $('.playbackBar .progress').width(newPercentage + '%');
            audioElement.setCurrentTimePercentage(newPercentage);
        });

        //Adjust volume p_1
        $('.volumeBar .progressBarBg').mousedown(function () {
            isVolumeClick = true;
            adjustVolume(event);
        });

        //Adjust volume p_2
        $(document).mousemove(function (event) {
            if(isVolumeClick){
                event.preventDefault();
                adjustVolume(event);
            }
        });

        //Adjust volume p_3
        $(document).mouseup(function (event) {
            isVolumeClick = false;
        });

        //Mute & unmute audio
        $('.volumeBar .controlButtons.volume').click(function () {
            if(!isMuted){
                $('.volumeBar .controlButtons.volume img').attr('src', 'assets/images/icons/volume-mute.png');
                audioElement.muteAudio();
                isMuted = true;
            } else {
                $('.volumeBar .controlButtons.volume img').attr('src', 'assets/images/icons/volume.png');
                audioElement.unmuteAudio();
                isMuted = false;
            }
        });

        //Prevent text selecting when you click and drag bar
        $('#nowPlayingBarContainer').on('mousedown touchstart mousemove touchmove', function (e) {
            e.preventDefault();
        });

        //Repeat and unrepeat song
        $('#nowPlayingCenter .controlButtons.repeat').click(function () {
            if(!isRepeat){
                $('#nowPlayingCenter .controlButtons.repeat img').attr('src', 'assets/images/icons/repeat-active.png');
                audioElement.repeatAudio();
            } else {
                $('#nowPlayingCenter .controlButtons.repeat img').attr('src', 'assets/images/icons/repeat.png');
                audioElement.unrepeatAudio();
            }
            isRepeat = !isRepeat;
        });

        //shuffle songs
        $('#nowPlayingCenter .controlButtons.shuffle').click(function () {
            if(!isShuffle){
                $('#nowPlayingCenter .controlButtons.shuffle img').attr('src', 'assets/images/icons/shuffle-active.png');
                shuffleCurrentPlaylist();
            } else {
                $('#nowPlayingCenter .controlButtons.shuffle img').attr('src', 'assets/images/icons/shuffle.png');
                unshuffleCurrentPlaylist();
            }
            isShuffle = !isShuffle;
        });

        //Play song when a song is selected and set album playlist
        $('.trackListRow .trackCount').click(function () {
            const trackId = $(this).find('.trackId').text();
            if(!isAlbumPlaylistSelected){
                isAlbumPlaylistSelected = true;
                currentPlaylist = albumPlaylist.slice();
            }
            currentCounterInPlayList = currentPlaylist.indexOf(trackId);
            getTrackFromServer(trackId, true);
        });

        //Set a random playlist
        currentPlaylist = <?php echo $randomSongsArray; ?>;
        albumPlaylist = <?php echo isset($songIds) ? json_encode($songIds) : '[]'; ?>;
        currentCounterInPlayList = setTrack(currentCounterInPlayList, currentPlaylist, audioElement, false);
    });
</script>

