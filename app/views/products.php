<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Glayza's Product Management</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5efe6;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        h1 {
            text-align: center;
            color: #5d4037;
            margin-bottom: 10px;
        }

        .welcome {
            text-align: center;
            color: #795548;
            margin-bottom: 25px;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            background: #795548;
        }

        .btn:hover {
            background: #5d4037;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: #795548;
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            color: #4e342e;
        }

        tr:hover {
            background: #f8f3ed;
        }

        .edit {
            color: #6d4c41;
            text-decoration: none;
            font-weight: bold;
            margin-right: 10px;
        }

        .delete {
            color: #c62828;
            text-decoration: none;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #795548;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>☕ Glayza's Product Management</h1>

    <div class="welcome">
        Welcome, User!
    </div>

    <div class="buttons">
        <a href="<?= site_url('products/create'); ?>" class="btn">
            + Add Product
        </a>

        <a href="<?= site_url('logout'); ?>" class="btn">
            Logout
        </a>
    </div>

    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

            <?php if (!empty($products)): ?>

                <?php foreach ($products as $product): ?>

                    <tr>

                        <td><?= $product['id']; ?></td>

                        <td><?= $product['product_name']; ?></td>

                        <td><?= $product['description']; ?></td>

                        <td>
                            ₱<?= number_format($product['price'], 2); ?>
                        </td>

                        <td><?= $product['quantity']; ?></td>

                        <td><?= $product['created_at']; ?></td>

                        <td>

                            <a
                                href="<?= site_url('products/edit/' . $product['id']); ?>"
                                class="edit"
                            >
                                Edit
                            </a>

                            <a
                                href="<?= site_url('products/delete/' . $product['id']); ?>"
                                class="delete"
                                onclick="return confirm('Are you sure you want to delete this product?');"
                            >
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="7" class="empty">
                        No products found.
                    </td>
                </tr>

            <?php endif; ?>

        </tbody>

    </table>

</div>

</body>
</html>