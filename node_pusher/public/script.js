// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher("4d99961ed8f70c04595a", {
    cluster: "ap1",
    encrypted: true,
    authEndpoint: "pusher/auth"
});
var usersOnline, id, users = [],
    sessionDesc,
    currentcaller, room, caller, localUserMedia;

const selfview = document.getElementById("selfview")
const remoteview = document.getElementById("remoteview")

selfview.addEventListener('loadedmetadata', function () {
    console.log(`Local video videoWidth: ${this.videoWidth}px,  videoHeight: ${this.videoHeight}px`);
});
remoteview.addEventListener('loadedmetadata', function () {
    console.log(`Remote video videoWidth: ${this.videoWidth}px,  videoHeight: ${this.videoHeight}px`);
});


const channel = pusher.subscribe('presence-videocall');

channel.bind('pusher:subscription_succeeded', (members) => {
    //set the member count
    usersOnline = members.count;
    id = channel.members.me.id;
    document.getElementById('myid').innerHTML = ` My caller id is : ` + id;
    members.each((member) => {
        if (member.id != channel.members.me.id) {
            users.push(member.id)
        }
    });

    render();
})

channel.bind('pusher:member_added', (member) => {
    users.push(member.id)
    render();
});

channel.bind('pusher:member_removed', (member) => {
    // for remove member from list:
    var index = users.indexOf(member.id);
    users.splice(index, 1);
    if (member.id == room) {
        endCall();
    }
    render();
});

//Listening for Session Description Protocol message with session details from remote peer
channel.bind("client-sdp", function (msg) {
    if (msg.room == id) {

        var answer = confirm("You have a call from: " + msg.from + "Would you like to answer?");
        if (!answer) {
            return channel.trigger("client-reject", { "room": msg.room, "rejected": id });
        }
        room = msg.room;
        getCam()
            .then(stream => {
                localUserMedia = stream;
                toggleEndCallButton();
                selfview.srcObject = stream;

                stream.getTracks().forEach((track) => {
                    caller.addTrack(track, stream)
                })

                caller.setRemoteDescription(msg.sdp).then(function () {
                    caller.createAnswer().then(async function (sdp) {
                        console.log("create answer:", sdp);
                        await caller.setLocalDescription(sdp);

                        channel.trigger("client-answer", {
                            "sdp": sdp,
                            "room": room
                        });
                    });
                })
            })
            .catch(error => {
                console.log('an error occured', error);
            })
    }
});

//Listening for the candidate message from a peer sent from onicecandidate handler
channel.bind("client-candidate", function (msg) {
    console.log(msg)
    if (msg.room == room) {
        // const candidate = new RTCIceCandidate(msg.candidate);

        caller.addIceCandidate(msg.candidate);
        console.log("candidate received", msg.candidate);
    }
});

//Listening for answer to offer sent to remote peer
channel.bind("client-answer", function (answer) {
    if (answer.room == room) {
        toggleEndCallButton();
        console.log("answer received", answer);
        caller.setRemoteDescription(answer.sdp);
        console.log('caller:', caller)

    }

});

channel.bind("client-reject", function (answer) {
    if (answer.room == room) {
        console.log("Call declined");
        alert("call to " + answer.rejected + "was politely declined");
        endCall();
    }

});

channel.bind("client-endcall", function (answer) {
    if (answer.room == room) {
        console.log("Call Ended");
        endCall();

    }

});

function render() {
    var list = '';
    users.forEach(function (user) {
        list += `<li>` + user + ` <input type="button" style="float:right;"  value="Call" onclick="callUser('` + user + `')" id="makeCall" /></li>`
    })
    document.getElementById('users').innerHTML = list;
}


prepareCaller()

async function prepareCaller() {

    // const serverConfig = {
    //     iceServers: [
    //         {
    //             urls: "stun:a.relay.metered.ca:80",
    //         },
    //         {
    //             urls: "turn:a.relay.metered.ca:443?transport=tcp",
    //             username: "60ba6f66dd6f99ec8e8f1bce",
    //             credential: "ldlyqPD7zZw1jAdj",
    //         },
    //     ]
    // }

    // const serverConfig = {
    //     iceServers: [
    //         { urls: ["stun:ss-turn2.xirsys.com"] },
    //         {
    //             username: "RWxBru_EK6BZK_QtXSnl8YVTjmuomsre-9YoQMBjaNl1epitM_QOSl-cq1zLjyJfAAAAAGQ2YX1rZW50b3M5Mw==",
    //             credential: "ee9753da-d905-11ed-97a0-0242ac140004",
    //             urls: [
    //                 "turn:ss-turn2.xirsys.com:80?transport=udp",
    //                 "turn:ss-turn2.xirsys.com:3478?transport=udp",
    //                 "turn:ss-turn2.xirsys.com:80?transport=tcp",
    //                 "turn:ss-turn2.xirsys.com:3478?transport=tcp",
    //                 "turns:ss-turn2.xirsys.com:443?transport=tcp",
    //                 "turns:ss-turn2.xirsys.com:5349?transport=tcp"
    //             ]
    //         }]
    // }

    // const serverConfig = {
    //     iceServers: [{
    //         urls: 'stun:coturn.development.my.id:5349'
    //     }, {
    //         urls: [
    //             'turn:coturn.development.my.id:5349?transport=tcp',
    //             'turn:coturn.development.my.id:3478?transport=tcp'
    //         ],
    //         credential: 'dev2023',
    //         username: 'milimeterdev1'
    //     }]
    // };

    const response = await fetch("twilio-iceserver");
    const twilio = await response.json();

    const serverConfig = {
        iceServers: twilio.iceServers
    };

    console.log('relay: ', serverConfig)


    //Initializing a peer connection
    caller = new RTCPeerConnection(serverConfig);

    caller.ontrack = (evt) => {
        console.log("ontrack called", evt.streams[0]);

        remoteview.srcObject = evt.streams[0]
    }

    //Listen for ICE Candidates and send them to remote peers
    caller.onicecandidate = function (evt) {
        if (!evt.candidate) return;
        console.log("onicecandidate called", evt);
        onIceCandidate(caller, evt);
    };

    caller.onconnectionstatechange = (ev) => {
        switch (caller.connectionState) {
            case "new":
            case "checking":
            case "connecting":
                setOnlineStatus("Connecting…");
                break;
            case "connected":
                setOnlineStatus("Online");
                break;
            case "disconnected":
                setOnlineStatus("Disconnecting…");
                break;
            case "closed":
                setOnlineStatus("Offline");
                break;
            case "failed":
                setOnlineStatus("Error");
                endCurrentCall();
                break;
            default:
                setOnlineStatus("Unknown");
                break;
        }
    };

    await getCam()
        .then(stream => {
            selfview.srcObject = stream;
            console.log("local:", stream);

            stream.getTracks().forEach((track) => {
                caller.addTrack(track, stream)
            })
            localUserMedia = stream;

        })
        .catch(error => {
            console.log('an error occured', error);
        })
}

async function getCam() {
    const stream = await navigator.mediaDevices.getUserMedia({ audio: true, video: true });
    return stream;
}

//Create and send offer to remote peer on button click
async function callUser(user) {
    await caller.createOffer({
        offerToReceiveAudio: 1,
        offerToReceiveVideo: 1
    }).then(async function (desc) {
        await caller.setLocalDescription(desc);
        // await caller.setRemoteDescription(desc);
        console.log('caller:', caller)

        channel.trigger("client-sdp", {
            "sdp": desc,
            "room": user,
            "from": id
        });
        room = user;
        console.log('Create Offer:', desc)
    });
};

//Send the ICE Candidate to the remote peer
async function onIceCandidate(peer, evt) {
    if (evt.candidate) {
        channel.trigger("client-candidate", {
            "candidate": evt.candidate,
            "room": room
        });
    }
}

function toggleEndCallButton() {
    if (document.getElementById("endCall").style.display == 'block') {
        document.getElementById("endCall").style.display = 'none';
    } else {
        document.getElementById("endCall").style.display = 'block';
    }
}

async function endCall() {
    room = undefined;
    caller.close();
    for (let track of localUserMedia.getTracks()) { track.stop() }
    toggleEndCallButton();
    prepareCaller();

}

function endCurrentCall() {

    channel.trigger("client-endcall", {
        "room": room
    });

    endCall();
}

function setOnlineStatus(status) {
    console.log('status: ', status)
    document.querySelector('#status').textContent = 'Status: ' + status
}
