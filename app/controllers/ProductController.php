
<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller
{
    protected $productModel;
    protected $refreshTokenModel;

    public function __construct()
    {
        parent::__construct();

        // ==========================================
        // DATABASE
        // ==========================================
        $this->call->database();

        // ==========================================
        // LOAD MODELS
        // ==========================================
        $this->call->model('ProductModel');
        $this->call->model('RefreshTokenModel');

        $this->productModel = $this->ProductModel;
        $this->refreshTokenModel = $this->RefreshTokenModel;
    }

    // ==========================================================
    // CORS HEADERS
    // ==========================================================
    private function setCorsHeaders()
    {
        header('Access-Control-Allow-Origin: http://localhost:5173');
        header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    }

    // ==========================================================
    // GET BEARER TOKEN
    // ==========================================================
    private function getBearerToken()
    {
        $authorization = '';

        // ------------------------------------------
        // Try getallheaders()
        // ------------------------------------------
        if (function_exists('getallheaders')) {
            $headers = getallheaders();

            foreach ($headers as $key => $value) {
                if (strtolower($key) === 'authorization') {
                    $authorization = $value;
                    break;
                }
            }
        }

        // ------------------------------------------
        // Apache / PHP fallback
        // ------------------------------------------
        if (!$authorization && isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authorization = $_SERVER['HTTP_AUTHORIZATION'];
        }

        // ------------------------------------------
        // Another Apache fallback
        // ------------------------------------------
        if (!$authorization && isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            $authorization = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }

        if (!$authorization) {
            return null;
        }

        // ------------------------------------------
        // Extract Bearer token
        // ------------------------------------------
        if (!preg_match('/Bearer\s+(.+)/i', $authorization, $matches)) {
            return null;
        }

        $token = trim($matches[1]);

        return $token !== '' ? $token : null;
    }

    // ==========================================================
    // AUTHENTICATE API REQUEST
    // ==========================================================
    private function authenticateRequest()
    {
        $this->setCorsHeaders();

        header('Content-Type: application/json');

        // ------------------------------------------
        // Get token
        // ------------------------------------------
        $token = $this->getBearerToken();

        if (!$token) {
            http_response_code(401);

            echo json_encode([
                'status' => false,
                'message' => 'Authentication token is required.'
            ]);

            return false;
        }

        // ------------------------------------------
        // Find token in refresh_tokens table
        // ------------------------------------------
        $record = null;

        $tokens = $this->refreshTokenModel->all();

        if ($tokens) {
            foreach ($tokens as $item) {

                $itemToken = is_object($item)
                    ? ($item->token ?? null)
                    : ($item['token'] ?? null);

                if ($itemToken === $token) {
                    $record = $item;
                    break;
                }
            }
        }

        // ------------------------------------------
        // Token not found
        // ------------------------------------------
        if (!$record) {
            http_response_code(401);

            echo json_encode([
                'status' => false,
                'message' => 'Invalid or expired token.'
            ]);

            return false;
        }

        // ------------------------------------------
        // Get expiration
        // ------------------------------------------
        $expiresAt = is_object($record)
            ? ($record->expires_at ?? null)
            : ($record['expires_at'] ?? null);

        // ------------------------------------------
        // Check expiration
        // ------------------------------------------
        if (!$expiresAt || strtotime($expiresAt) <= time()) {
            http_response_code(401);

            echo json_encode([
                'status' => false,
                'message' => 'Invalid or expired token.'
            ]);

            return false;
        }

        // ------------------------------------------
        // Token is valid
        // ------------------------------------------
        return true;
    }

    // ==========================================================
    // GET /api/products
    // ==========================================================
    public function index()
    {
        if (!$this->authenticateRequest()) {
            return;
        }

        $products = $this->productModel->all();

        echo json_encode([
            'status' => true,
            'message' => 'Products retrieved successfully.',
            'data' => $products
        ]);
    }

    // ==========================================================
    // GET /api/products/{id}
    // ==========================================================
    public function show($id)
    {
        if (!$this->authenticateRequest()) {
            return;
        }

        $product = $this->productModel->find($id);

        if (!$product) {
            http_response_code(404);

            echo json_encode([
                'status' => false,
                'message' => 'Product not found.'
            ]);

            return;
        }

        echo json_encode([
            'status' => true,
            'message' => 'Product retrieved successfully.',
            'data' => $product
        ]);
    }

    // ==========================================================
    // POST /api/products
    // ==========================================================
    public function store()
    {
        if (!$this->authenticateRequest()) {
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (!is_array($input)) {
            http_response_code(400);

            echo json_encode([
                'status' => false,
                'message' => 'Invalid JSON request.'
            ]);

            return;
        }

        $data = [
            'product_name' => $input['product_name'] ?? '',
            'description'  => $input['description'] ?? '',
            'price'        => $input['price'] ?? 0,
            'quantity'     => $input['quantity'] ?? 0
        ];

        $this->productModel->insert($data);

        http_response_code(201);

        echo json_encode([
            'status' => true,
            'message' => 'Product created successfully.',
            'data' => $data
        ]);
    }

    // ==========================================================
    // PUT /api/products/{id}
    // ==========================================================
    public function update($id)
    {
        if (!$this->authenticateRequest()) {
            return;
        }

        $product = $this->productModel->find($id);

        if (!$product) {
            http_response_code(404);

            echo json_encode([
                'status' => false,
                'message' => 'Product not found.'
            ]);

            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (!is_array($input)) {
            http_response_code(400);

            echo json_encode([
                'status' => false,
                'message' => 'Invalid JSON request.'
            ]);

            return;
        }

        $data = [
            'product_name' => $input['product_name'] ?? $product->product_name,
            'description'  => $input['description'] ?? $product->description,
            'price'        => $input['price'] ?? $product->price,
            'quantity'     => $input['quantity'] ?? $product->quantity
        ];

        $this->productModel->update($id, $data);

        echo json_encode([
            'status' => true,
            'message' => 'Product updated successfully.',
            'data' => $data
        ]);
    }

    // ==========================================================
    // PATCH /api/products/{id}
    // ==========================================================
    public function patch($id)
    {
        if (!$this->authenticateRequest()) {
            return;
        }

        $product = $this->productModel->find($id);

        if (!$product) {
            http_response_code(404);

            echo json_encode([
                'status' => false,
                'message' => 'Product not found.'
            ]);

            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (!is_array($input)) {
            http_response_code(400);

            echo json_encode([
                'status' => false,
                'message' => 'Invalid JSON request.'
            ]);

            return;
        }

        $data = [];

        if (isset($input['product_name'])) {
            $data['product_name'] = $input['product_name'];
        }

        if (isset($input['description'])) {
            $data['description'] = $input['description'];
        }

        if (isset($input['price'])) {
            $data['price'] = $input['price'];
        }

        if (isset($input['quantity'])) {
            $data['quantity'] = $input['quantity'];
        }

        if (empty($data)) {
            http_response_code(400);

            echo json_encode([
                'status' => false,
                'message' => 'No fields provided for update.'
            ]);

            return;
        }

        $this->productModel->update($id, $data);

        echo json_encode([
            'status' => true,
            'message' => 'Product partially updated successfully.',
            'data' => $data
        ]);
    }

    // ==========================================================
    // DELETE /api/products/{id}
    // ==========================================================
    public function delete($id)
    {
        if (!$this->authenticateRequest()) {
            return;
        }

        $product = $this->productModel->find($id);

        if (!$product) {
            http_response_code(404);

            echo json_encode([
                'status' => false,
                'message' => 'Product not found.'
            ]);

            return;
        }

        $this->productModel->delete($id);

        echo json_encode([
            'status' => true,
            'message' => 'Product deleted successfully.'
        ]);
    }
}
