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

        //Set a random playlist
        currentPlaylist = <?php echo $randomSongsArray; ?>;
        currentCounterInPlayList = setTrack(currentCounterInPlayList, currentPlaylist, audioElement, false);
    });
</script>

