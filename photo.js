
(function(){
    var video = document.getElementById('video'),
        canvas = document.getElementById('canvas'),
        context = canvas.getContext('2d'),
        photo = document.getElementById('photo'),
        vendorUrl = window.URL || window.webkitURL;
    navigator.getMedia = navigator.getUserMedia || navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia || navigator.oGetUserMedia || navigator.msGetUserMedia;
    // if (navigator.getUserMedia){
    //     	navigator.getUserMedia({video:true}, streamWebCam, throwError);
    // }
    navigator.getMedia({
        video: true,
        audio: false
    }, function(stream){
        try{
            video.srcObject = stream;
        }
        catch (error){
            video.src = vendorUrl.createObjectURL(stream);
        }
        video.play();
    }, function(error) {
        alert(e.name);
    });
    document.getElementById('capture').addEventListener('click', function(){
        context.drawImage(video, 0, 0, 400, 300);
        photo.setAttribute('src', canvas.toDataURL('image/png'));
    });
    
})();