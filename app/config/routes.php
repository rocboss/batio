<?php

route('GET /', ['api\HomeController', 'index']);

route('GET /user', ['api\HomeController', 'user'])->auth('web');
