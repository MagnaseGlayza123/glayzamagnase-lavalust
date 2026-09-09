<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductsController extends Controller
{
    public function index()
    {
        $this->call->database();
        $this->call->model('ProductsModel');

        $products = $this->ProductsModel->all();

        $this->call->view('products', [
            'products' => $products
        ]);
    }

    public function create()
    {
        $this->call->view('product_form');
    }

    public function store()
    {
        $this->call->database();
        $this->call->model('ProductsModel');

        $data = [
            'product_name' => $_POST['product_name'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'quantity' => $_POST['quantity']
        ];

        $this->ProductsModel->insert($data);

        redirect('/products');
    }

    public function edit($id)
    {
        $this->call->database();
        $this->call->model('ProductsModel');

        $product = $this->ProductsModel->find($id);

        $this->call->view('product_form', [
            'product' => $product
        ]);
    }

    public function update($id)
    {
        $this->call->database();
        $this->call->model('ProductsModel');

        $data = [
            'product_name' => $_POST['product_name'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'quantity' => $_POST['quantity']
        ];

        $this->ProductsModel->update($id, $data);

        redirect('/products');
    }

    public function delete($id)
    {
        $this->call->database();
        $this->call->model('ProductsModel');

        $this->ProductsModel->delete($id);

        redirect('/products');
    }
}

?>
