// variable declaration
var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var path = require('path');
var port = 9009;

// GET If you want to create an index.html (optional)
app.get('/', function(req, res){
  res.sendFile(path.resolve(__dirname + '/../index.html'));
});

// Socket.io connection
io.on('connection', function(socket){
  // listen is server ID for clients
  // data are the response data
  console.log('a user connected');
  socket.on('listen', function(data){
    console.log('client connected');

    // Example 1: send broadcast for all clients ID 'user'
    io.emit('user', {name: 'Marcelo Aires'});

    // Example 2: send broadcast for all clients ID 'user2'
    io.emit('user2', 1);
  });

  // If some user disconnect
  socket.on('disconnect', function(){
    console.log('user disconnected');
  })
});

// port: port that server is listening
http.listen(port, function(){
  console.log('listening on *:' + port);
});