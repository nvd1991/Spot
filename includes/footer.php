<!--footer.php-->
                <!--content here-->
                </div>
            </div>
        </div>
        <!--now playing bar container-->
        <?php include 'includes/nowPlayingBarContainer.php'; ?>
        <?php $randomSongsArray = json_encode(Song::get_random_songs($connection, 5)); ?>
        <?php include 'includes/generated-scripts/script-generated.php'; ?>
    </div>
</body>
</html>
