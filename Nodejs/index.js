var server = require("./route/server");
var router = require("./route/route");

server.start(router.route);