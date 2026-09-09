<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= isset($product) ? 'Edit Product' : 'Add Product'; ?> - Glayza's CRUD</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5efe6;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        h1 {
            text-align: center;
            color: #5d4037;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            color: #5d4037;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        textarea {
            height: 120px;
            resize: vertical;
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

        .back {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #795548;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>
        <?= isset($product) ? 'Edit Product' : 'Add Product'; ?>
    </h1>

    <?php if (isset($product)): ?>

        <form action="<?= site_url('products/update/' . $product['id']); ?>" method="POST">

    <?php else: ?>

        <form action="<?= site_url('products/store'); ?>" method="POST">

    <?php endif; ?>

        <label>Product Name</label>

        <input
            type="text"
            name="product_name"
            value="<?= isset($product) ? $product['product_name'] : ''; ?>"
            placeholder="Enter product name"
            required
        >

        <label>Description</label>

        <textarea
            name="description"
            placeholder="Enter product description"
        ><?= isset($product) ? $product['description'] : ''; ?></textarea>

        <label>Price</label>

        <input
            type="number"
            name="price"
            step="0.01"
            min="0"
            value="<?= isset($product) ? $product['price'] : ''; ?>"
            placeholder="Enter price"
            required
        >

        <label>Quantity</label>

        <input
            type="number"
            name="quantity"
            min="0"
            value="<?= isset($product) ? $product['quantity'] : ''; ?>"
            placeholder="Enter quantity"
            required
        >

        <button type="submit">
            <?= isset($product) ? 'Update Product' : 'Add Product'; ?>
        </button>

    </form>

    <a href="<?= site_url('products'); ?>" class="back">
        ← Back to Products
    </a>

</div>

</body>
</html>
