<?php

include "../init.php";

session_start();
session_unset();
session_destroy();

redirect($blog_home);