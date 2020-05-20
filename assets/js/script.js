$(document).scroll(function() {
    var isScrolled = $(this).scrollTop() > $(".topBar").height();
    $(".topBar").toggleClass("scrolled", isScrolled); // if isScrolled is true, add scrolled class under topBar
})

function volumeToggle(button){
    var muted = $(".previewVideo").prop("muted");
    $(".previewVideo").prop("muted", !muted);

    $(button).find("i").toggleClass("fa-volume-mute"); // if find, remove it.
    $(button).find("i").toggleClass("fa-volume-up"); // if not find, add it.
}

function previewEnded(){
    $(".previewVideo").toggle();
    $(".previewImage").toggle();
}

function goBack(){
    window.history.back();
}

function startHideTimer(){
    var timeout = null;
    $(document).on("mousemove", function() {
        clearTimeout(timeout);
        $(".watchNav").fadeIn();

        timeout = setTimeout(function() {
            $(".watchNav").fadeOut();
        }, 2000);
    })
}

function initVideo(videoId, username){
    startHideTimer();
    setStartTime(videoId, username);
    //for testing, it will show on console
    //console.log(videoId);
    //console.log(userLoggedIn);
    updateProgressTimer(videoId, username);
}

function updateProgressTimer(videoId, username){
    addDuration(videoId, username);

    var timer;
    $("video").on("playing", function(event) {
       window.clearInterval(timer);
       timer = window.setInterval(function() {
            //console.log("hi");
            updateProgress(videoId, username, event.target.currentTime);
       }, 3000);   
    })
    .on("ended", function() {
        setFinished(videoId, username);
        window.clearInterval(timer);
    })
}

function addDuration(videoId, username) {
    $.post("ajax/addDuration.php", { videoId: videoId, username: username}, function(data){
       if(data !== null && data !== ""){ // !== type checking
            alert(data); // data is the return value from addDuration
       }
    })
}

function updateProgress(videoId, username, progress){
    $.post("ajax/updateDuration.php", { videoId: videoId, username: username, progress: progress}, function(data){
        if(data !== null && data !== ""){ // !== type checking
             alert(data); // data is the return value from addDuration
        }
     })
}

function setFinished(videoId, username, progress){
    $.post("ajax/setFinished.php", { videoId: videoId, username: username}, function(data){
        if(data !== null && data !== ""){ // !== type checking
             alert(data); // data is the return value from addDuration
        }
     })
}

function setStartTime(videoId, username, progress){
    $.post("ajax/getProgress.php", { videoId: videoId, username: username}, function(data){
        if(isNaN(data)){ // not an number
            alert(data); // show error message
        }

        $("video").on("canplay", function() {
            this.currentTime = data;
            $("video").off("canplay");
        })
     })
}

function restartVideo(){
    $("video")[0].currentTime = 0;
    $("video")[0].play();
    $(".upNext").fadeOut();
}

function watchVideo(videoId) {
    window.location.href = "watch.php?id=" + videoId;
}

function showUpNext(){
    $(".upNext").fadeIn();
}