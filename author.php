<?php 
	if ($_SERVER['HTTP_REFERER'] != null) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    } else {
		header("Location: ".get_home_url());
		exit();
	}