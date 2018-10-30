
(function(){
    var video = document.getElementById('video'),
        canvas = document.getElementById('canvas'),
        context = canvas.getContext('2d'),
        photo = document.getElementById('photo'),
        download = document.getElementById('download'),
        sticker1 = document.getElementById('sticker1'),
        sticker2 = document.getElementById('sticker2'),
        sticker3 = document.getElementById('sticker3'),
        sticker4 = document.getElementById('sticker4'),
        vendorUrl = window.URL || window.webkitURL;
    navigator.getMedia = navigator.getUserMedia || navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia || navigator.oGetUserMedia || navigator.msGetUserMedia;
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
        if (typeof sticker !== 'undefined'){
                context.drawImage(video, 0, 0, 400, 300),
                context.drawImage(sticker, 0, 0, 400, 300);
                photo.setAttribute('src', canvas.toDataURL('image/png'));
        }
        else{
            alert("Please select a filter");
        }
    });



    download.addEventListener('click', function(){
        var hr = new XMLHttpRequest();
        var url = "server.php";
        var username = '<?php echo ($_SESSION["username"]); ?>';
        var picture = (encodeURIComponent(JSON.stringify(photo.src)));
        var vars = "username="+username+"&picture="+picture+"&submit_picture=true";
        hr.open("POST", url, true);
        hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        hr.onreadystatechange = function(){
            if (hr.readyState == 4 && hr.status == 200){
                var return_data = hr.responseText;
                document.getElementById("status").innerHTML = return_data;
            }
        }
        hr.send(vars);
    });



    sticker1.addEventListener('click', function(){
        sticker = new Image();
        sticker.src = 'images/sticker1.png';
        live.src = sticker.src;
    });
    sticker2.addEventListener('click', function(){
        sticker = new Image();
        sticker.src = 'images/sticker2.png';
        live.src = sticker.src;
    });
    sticker3.addEventListener('click', function(){
        sticker = new Image();
        sticker.src = 'images/sticker3.png';
        live.src = sticker.src;
    });
    sticker4.addEventListener('click', function(){
        sticker = new Image();
        sticker.src = 'images/sticker4.png';
        live.src = sticker.src;
    });
})();