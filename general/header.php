<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="questiontest.css">
	<title>QUESTION-TEST</title>
	<style>
		body{
			font-family: Arial, helvetica, sans-serif;
			background-color: #eee;
		}
		.login-form{
			height: 100vh;
			display: flex;
		}
		.login-form form{
			display: inline-flex;
			width: 50%;
			margin: auto;
			color: #444;
		}
		.login-form-container{
			padding: 16px;
			background-color: white;
			box-shadow: 0px 10px 20px rgba(0,0,0,0.5);
		}
		.login-form h2{
			text-align: center;
			margin-bottom: 20px;
			padding: 10px;
		}
		.login-form input{
			width: 100%;
			padding: 12px 20px;
			margin: 8px 0;
			display: inline-block;
			border: 1px solid #ccc;
			box-sizing: border-box;
		}
		.login-form .submitlogin{
			background: #eee;
			color: black;
			padding: 14px 20px;
			margin: 8px 0;
			border: none;
			cursor: pointer;
			width: 100%;
			border: 1px solid black;
			font-size: 18px;
			font-weight: bold;
		}
		.login-form .submitlogin:hover{
			background: #444;
			color: white;
		}
	</style>
</head>
<body>