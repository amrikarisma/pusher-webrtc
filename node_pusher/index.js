const express = require('express');
const bodyParser = require('body-parser');
const Pusher = require('pusher');
const app = express();


// Body parser middleware
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
// Session middleware

app.use(express.static('public'))

// Create an instance of Pusher
const pusher = new Pusher({
    appId: process.env.APP_ID,
    key: process.env.APP_KEY,
    secret: process.env.APP_SECRET,
    cluster: process.env.APP_CLUSTER,
});

app.get('/', (req, res) => {
    return res.sendFile(__dirname + '/index.html');
});

app.get('/twilio-iceserver', async (req, res) => {

    const accountSid = process.env.TWILIO_ACCOUNT_SID;
    const authToken = process.env.TWILIO_AUTH_TOKEN;
    const client = require('twilio')(accountSid, authToken);

    let token = await client.tokens.create();
    res.send(token);

});

// get authentictation for the channel;
app.post("/pusher/auth", (req, res) => {
    const socketId = req.body.socket_id;
    const channel = req.body.channel_name;
    var presenceData = {
        user_id:
            Math.random()
                .toString(36)
                .slice(2) + Date.now()
    };
    const auth = pusher.authenticate(socketId, channel, presenceData);
    res.send(auth);
});

//listen on the app
app.listen(3000, () => {
    return console.log('Server is up on 3000')
});

module.exports = app
