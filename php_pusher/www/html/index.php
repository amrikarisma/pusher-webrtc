<!DOCTYPE html>
<html>

<head>
    <title>WebRTC Audio/Video-Chat</title>
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
        }

        .container video {
            width: 40%;
            flex: 1;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="title">WebRTC Audio/Video-Chat</div>
        <span id="myid"> </span>
        <div class="container">
            <video id="selfview" playsinline autoplay muted></video>
            <video id="remoteview" playsinline autoplay></video>

        </div>
        <div>
            <button id="endCall" style="display: none;" onclick="endCurrentCall()">End Call </button>
            <div id="list">
                <ul id="users">

                </ul>
            </div>
        </div>
    </div>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <!-- <script src="https://js.pusher.com/4.1/pusher.min.js"></script> -->
    <script src="/script.js"></script>
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

        #list ul li:hover {
            -moz-transform: rotate(-5deg);
            -moz-box-shadow: 10px 10px 20px #000000;
            -webkit-transform: rotate(-5deg);
            -webkit-box-shadow: 10px 10px 20px #000000;
            transform: rotate(-5deg);
            box-shadow: 10px 10px 20px #000000;
        }
    </style>

</body>

</html>