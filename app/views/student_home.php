<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>A Cup of Student Life</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Georgia, serif;
            background: #f3e5d0;
            color: #3e2723;
        }

        nav {
            background: #4e342e;
            padding: 20px 45px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav h2 {
            color: #fff8e7;
            margin: 0;
            letter-spacing: 1px;
        }

        nav a {
            color: #fbe9d0;
            text-decoration: none;
            margin-left: 25px;
            font-weight: bold;
        }

        nav a:hover {
            color: #d7a86e;
        }

        .container {
            max-width: 900px;
            margin: 75px auto;
            padding: 65px 55px;
            background: #fffaf2;
            border-left: 8px solid #795548;
            border-radius: 6px;
            box-shadow: 0 12px 30px rgba(78, 52, 46, 0.18);
        }

        .coffee-icon {
            font-size: 55px;
            margin-bottom: 10px;
        }

        h1 {
            margin-top: 0;
            color: #5d4037;
            font-size: 42px;
        }

        .subtitle {
            color: #795548;
            font-size: 20px;
            line-height: 1.7;
        }

        .description {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.8;
            color: #5a4742;
        }

        .button {
            display: inline-block;
            margin-top: 25px;
            padding: 14px 25px;
            background: #795548;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-family: Arial, sans-serif;
            font-weight: bold;
        }

        .button:hover {
            background: #5d4037;
        }
    </style>
</head>

<body>

<nav>
    <h2>☕ Glayza's Coffee Student Hub</h2>

    <div>
        <a href="<?= site_url('student'); ?>">Home</a>
        <a href="<?= site_url('student/profile'); ?>">My Profile</a>
    </div>
</nav>

<div class="container">

    <div class="coffee-icon">☕</div>

    <h1>A Cup of Student Life</h1>

    <p class="subtitle">
        Welcome to Glayza's personal student space.
    </p>

    <p class="description">
        This page is a simple student information application
        created using the LavaLust PHP Framework.
    </p>

    <p class="description">
        Take a little coffee break and explore my student profile.
    </p>

    <a class="button" href="<?= site_url('student/profile'); ?>">
        View My Profile →
    </a>

</div>

</body>
</html>