<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Glayza's Coffee Profile</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Georgia, serif;
            background: #ead7c0;
            color: #3e2723;
        }

        nav {
            background: #3e2723;
            padding: 22px 45px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav h2 {
            color: #fff8e7;
            margin: 0;
            font-size: 22px;
        }

        nav a {
            color: #ead7c0;
            text-decoration: none;
            margin-left: 25px;
            font-family: Arial, sans-serif;
            font-weight: bold;
        }

        nav a:hover {
            color: #c49a6c;
        }

        .profile-card {
            max-width: 850px;
            margin: 55px auto;
            background: #fffaf3;
            padding: 45px;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(62, 39, 35, 0.2);
        }

        .heading {
            text-align: center;
            margin-bottom: 35px;
        }

        .cup {
            font-size: 48px;
            margin-bottom: 8px;
        }

        h1 {
            margin: 0;
            color: #5d4037;
            font-size: 36px;
        }

        .intro {
            color: #795548;
            font-family: Arial, sans-serif;
            margin-top: 10px;
        }

        .details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 30px;
        }

        .info {
            padding: 20px;
            background: #f1e2d0;
            border-radius: 8px;
            border-bottom: 3px solid #8d6e63;
        }

        .label {
            display: block;
            font-family: Arial, sans-serif;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #795548;
            margin-bottom: 7px;
            font-weight: bold;
        }

        .value {
            font-size: 18px;
            color: #3e2723;
            word-break: break-word;
        }

        .back {
            display: block;
            width: fit-content;
            margin: 35px auto 0;
            padding: 13px 25px;
            background: #795548;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-weight: bold;
        }

        .back:hover {
            background: #5d4037;
        }

        @media (max-width: 650px) {
            .details {
                grid-template-columns: 1fr;
            }

            nav {
                padding: 20px;
            }

            nav a {
                margin-left: 10px;
            }

            .profile-card {
                margin: 30px 15px;
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>

<nav>
    <h2>☕ Glayza's Coffee Hub</h2>

    <div>
        <a href="<?= site_url('student'); ?>">Home</a>
        <a href="<?= site_url('student/profile'); ?>">Profile</a>
    </div>
</nav>

<div class="profile-card">

    <div class="heading">
        <div class="cup">☕</div>

        <h1>My Student Profile</h1>

        <p class="intro">
            A little cup of information about Glayza.
        </p>
    </div>

    <div class="details">

        <div class="info">
            <span class="label">Student ID</span>
            <span class="value"><?= $student_id; ?></span>
        </div>

        <div class="info">
            <span class="label">Student Name</span>
            <span class="value"><?= $name; ?></span>
        </div>

        <div class="info">
            <span class="label">Course</span>
            <span class="value"><?= $course; ?></span>
        </div>

        <div class="info">
            <span class="label">Year Level</span>
            <span class="value"><?= $year; ?></span>
        </div>

        <div class="info">
            <span class="label">Section</span>
            <span class="value"><?= $section; ?></span>
        </div>

        <div class="info">
            <span class="label">Email</span>
            <span class="value"><?= $email; ?></span>
        </div>

    </div>

    <a class="back" href="<?= site_url('student'); ?>">
        ← Back to Coffee Hub
    </a>

</div>

</body>
</html>