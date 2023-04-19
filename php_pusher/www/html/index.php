<?php
require_once('loader.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Video Call with Pusher and WebRTC</title>
    <style>
        body {
            background-color: #141a36;
            color: #fff;
        }

        a {
            color: #fff;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            justify-content: center;
        }

        .gx-5 {
            gap: 15px;
        }

        .container .video-wrap {
            position: relative;
            width: 40%;
            flex: 1;
            height: 100%;
        }

        .video-wrap .name {
            position: absolute;
            left: 50px;
            bottom: 50px;
            background-color: #00000091;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .container video {
            width: 90%;
            aspect-ratio: 16/11;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="title">WebRTC Audio/Video-Chat</div>
        <audio id="xyz" src="assets/audio/phone-ringing-6805.mp3" preload="auto"></audio>
        <div style="display:flex;width: 100%;justify-content: space-between;">
            <div>
                <span id="myid"> </span>
                <div>
                    Email : <span id="userEmail"><?php echo get_user()['email']; ?></span>
                </div>
            </div>
            <div>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <div class="container">
            <div class="video-wrap">
                <video id="selfview" playsinline autoplay muted></video>
                <div class="name">Me (<?php echo get_user()['name']; ?>)</div>
            </div>
            <div class="video-wrap">
                <video id="remoteview" playsinline autoplay></video>
                <div class="name" id="remoteName">Remote (Waiting...)</div>
            </div>
        </div>
        <div>
            <div class="container gx-5">
                <div id="status"></div>
                <button id="endCall" style="display: none;" onclick="endCurrentCall()">End Call </button>
            </div>
            <div id="list">
                <h3 style="margin-left: 50px;">Members Online</h3>
                <ul id="users">

                </ul>
            </div>
        </div>
    </div>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="script.js?v=2"></script>
    <style>
        video {
            /* video border */
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px;
            border-radius: 20px;
            /* tranzitionstransitions applied to the vodeovideo element */
            -moz-transition: all 1s ease-in-out;
            -webkit-transition: all 1s ease-in-out;
            -o-transition: all 1s ease-in-out;
            -ms-transition: all 1s ease-in-out;
            transition: all 1s ease-in-out;
        }

        #list ul {
            list-style: none;
        }

        #list ul li {
            font-family: Georgia, serif, Times;
            font-size: 18px;
            display: block;
            width: 300px;
            height: 28px;
            background-color: #333;
            border-left: 5px solid #222;
            border-right: 5px solid #222;
            padding-left: 10px;
            text-decoration: none;
            color: #bfe1f1;
        }

        /* #list ul li:hover {
            -moz-transform: rotate(-5deg);
            -moz-box-shadow: 10px 10px 20px #000000;
            -webkit-transform: rotate(-5deg);
            -webkit-box-shadow: 10px 10px 20px #000000;
            transform: rotate(-5deg);
            box-shadow: 10px 10px 20px #000000;
        } */
    </style>

</body>

</html>