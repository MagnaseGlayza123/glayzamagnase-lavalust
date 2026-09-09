<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Glayza's CRUD</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5efe6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-box {
            width: 380px;
            padding: 35px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        h1 {
            text-align: center;
            color: #5d4037;
        }

        .subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            color: #5d4037;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #795548;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #5d4037;
        }

        .error {
            background: #ffe5e5;
            color: #b00020;
            padding: 10px;
            border-radius: 7px;
            margin-bottom: 15px;
            text-align: center;
        }

        .note {
            text-align: center;
            color: #888;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h1>Glayza's CRUD</h1>

    <p class="subtitle">Login to continue</p>

    <?php if (isset($error)): ?>
        <div class="error">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('login'); ?>" method="POST">

        <label for="username">Username</label>
        <input
            type="text"
            id="username"
            name="username"
            placeholder="Enter username"
            required
        >

        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Enter password"
            required
        >

        <button type="submit">Login</button>

    </form>

    <p class="note">For school purposes only.</p>

</div>

</body>
</html>
