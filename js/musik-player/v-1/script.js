var audio = new Audio(audiosrc);
      var playPauseBtn = document.getElementById('playPauseBtn');
      var progressBar = document.getElementById('progressBar');
      var currentTime = document.getElementById('currentTime');
      var isPlaying = false;
  
      audio.addEventListener('loadedmetadata', function() {
        currentTime.textContent = formatTime(audio.currentTime) + ' - ' + formatTime(audio.duration);
      });
      
      playPauseBtn.addEventListener('click', function() {
        if (isPlaying) {
          audio.pause();
          playPauseBtn.innerHTML = '<i class="bi bi-play-circle fs-4"></i>';
        } else {
          audio.play();
          playPauseBtn.innerHTML = '<i class="bi bi-pause-circle fs-4"></i>';
        }
        isPlaying = !isPlaying;
      });
      
      audio.addEventListener('timeupdate', function() {
        var progress = (audio.currentTime / audio.duration) * 100;
        progressBar.style.width = progress + '%';
        currentTime.textContent = formatTime(audio.currentTime) + ' - ' + formatTime(audio.duration);
      });
      
      progressBar.addEventListener('click', function(event) {
        var progressBarWidth = progressBar.offsetWidth;
        var clickedX = event.clientX - progressBar.getBoundingClientRect().left;
        var progress = (clickedX / progressBarWidth) * audio.duration;
        audio.currentTime = progress;
      });
      
      function formatTime(time) {
        var minutes = Math.floor(time / 60);
        var seconds = Math.floor(time % 60);
        if (seconds < 10) {
          seconds = '0' + seconds;
        }
        return minutes + ':' + seconds;
      }
