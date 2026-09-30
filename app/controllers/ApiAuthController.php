
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiAuthController extends Controller
{
    protected $refreshTokenModel;

    public function __construct()
    {
        parent::__construct();

        $this->call->database();
        $this->call->model('RefreshTokenModel');

        $this->refreshTokenModel = new RefreshTokenModel();
    }

    /**
     * CORS headers
     */
    private function cors()
    {
        $allowedOrigins = [
            'http://localhost:5173',
            'http://localhost:5174',
            'https://product-management-react.onrender.com',
        ];

        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

        if (in_array($origin, $allowedOrigins, true)) {
            header("Access-Control-Allow-Origin: $origin");
        }

        header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Access-Control-Allow-Credentials: true');
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
    }

    /**
     * Generate random token
     */
    private function generateToken($length = 64)
    {
        return bin2hex(random_bytes($length / 2));
    }

    /**
     * Login
     */
    public function login()
    {
        $this->cors();

        $rawInput = file_get_contents('php://input');

        // Remove possible UTF-8 BOM
        $rawInput = preg_replace('/^\xEF\xBB\xBF/', '', $rawInput);

        $data = json_decode($rawInput, true);

        if (!is_array($data)) {
            $data = $_POST;
        }

        $username = trim($data['username'] ?? '');
        $password = $data['password'] ?? '';

        // Lab 6 credentials
        if ($username !== 'admin' || $password !== 'admin123') {
            http_response_code(401);

            echo json_encode([
                'success' => false,
                'message' => 'Invalid username or password.'
            ]);

            return;
        }

        try {
            $token = $this->generateToken(64);
            $jti = $this->generateToken(32);

            // Token valid for 24 hours
            $expiresAt = date('Y-m-d H:i:s', time() + (24 * 60 * 60));

            $inserted = $this->refreshTokenModel->insert([
                'user_id' => 1,
                'token' => $token,
                'expires_at' => $expiresAt,
                'jti' => $jti
            ]);

            if (!$inserted) {
                http_response_code(500);

                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to save authentication token.'
                ]);

                return;
            }

            http_response_code(200);

            echo json_encode([
                'success' => true,
                'message' => 'Login successful.',
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => $expiresAt,
                'user' => [
                    'id' => 1,
                    'username' => 'admin'
                ]
            ]);

        } catch (Exception $e) {
            http_response_code(500);

            echo json_encode([
                'success' => false,
                'message' => 'Login failed.',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->cors();

        $token = $this->getBearerToken();

        if (!$token) {
            http_response_code(401);

            echo json_encode([
                'success' => false,
                'message' => 'Authorization token is required.'
            ]);

            return;
        }

        try {
            $this->refreshTokenModel
                ->where('token', $token)
                ->delete();

            http_response_code(200);

            echo json_encode([
                'success' => true,
                'message' => 'Logout successful.'
            ]);

        } catch (Exception $e) {
            http_response_code(500);

            echo json_encode([
                'success' => false,
                'message' => 'Logout failed.',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get Bearer token from request headers
     */
    private function getBearerToken()
    {
        $headers = [];

        if (function_exists('getallheaders')) {
            $headers = getallheaders();
        }

        $authorization = '';

        if (isset($headers['Authorization'])) {
            $authorization = $headers['Authorization'];
        } elseif (isset($headers['authorization'])) {
            $authorization = $headers['authorization'];
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authorization = $_SERVER['HTTP_AUTHORIZATION'];
        } elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            $authorization = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        } elseif (function_exists('apache_request_headers')) {
            $apacheHeaders = apache_request_headers();

            if (isset($apacheHeaders['Authorization'])) {
                $authorization = $apacheHeaders['Authorization'];
            } elseif (isset($apacheHeaders['authorization'])) {
                $authorization = $apacheHeaders['authorization'];
            }
        }

        if (preg_match('/Bearer\s+(.+)/i', $authorization, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }

    /**
     * Find and validate token
     */
    public function findToken($token)
    {
        if (!$token) {
            return false;
        }

        $result = $this->refreshTokenModel
            ->where('token', $token)
            ->get();

        if (!$result) {
            return false;
        }

        if (is_array($result)) {
            $tokenData = $result[0] ?? null;
        } else {
            $tokenData = $result;
        }

        if (!$tokenData) {
            return false;
        }

        $expiresAt = $tokenData['expires_at'] ?? null;

        if (!$expiresAt) {
            return false;
        }

        if (strtotime($expiresAt) <= time()) {
            return false;
        }

        return $tokenData;
    }
}
?>
