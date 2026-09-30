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

        $this->refreshTokenModel = $this->RefreshTokenModel;
    }

    // ==========================================
    // CORS HEADERS
    // ==========================================
    private function setCorsHeaders()
    {
        header('Access-Control-Allow-Origin: http://localhost:5173');
        header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    }

    // ==========================================
    // POST /api/login
    // ==========================================
    public function login()
    {
        $this->setCorsHeaders();

        header('Content-Type: application/json');

        // Get raw JSON request
        $rawInput = file_get_contents('php://input');

        // Remove UTF-8 BOM if present
        $rawInput = preg_replace('/^\xEF\xBB\xBF/', '', $rawInput);

        // Remove unnecessary whitespace
        $rawInput = trim($rawInput);

        // Decode JSON
        $input = json_decode($rawInput, true);

        // Check if JSON is valid
        if (!is_array($input)) {
            http_response_code(400);

            echo json_encode([
                'status' => false,
                'message' => 'Invalid JSON request.'
            ]);

            return;
        }

        // Get username and password
        $username = $input['username'] ?? '';
        $password = $input['password'] ?? '';

        // ==========================================
        // CHECK LOGIN CREDENTIALS
        // ==========================================

        if ($username !== 'admin' || $password !== 'admin123') {
            http_response_code(401);

            echo json_encode([
                'status' => false,
                'message' => 'Invalid username or password.'
            ]);

            return;
        }

        // ==========================================
        // GENERATE ACCESS TOKEN
        // ==========================================

        $token = bin2hex(random_bytes(32));

        // Generate token identifier
        $jti = bin2hex(random_bytes(16));

        // Token expires after 24 hours
        $expiresAt = date(
            'Y-m-d H:i:s',
            time() + (24 * 60 * 60)
        );

        // ==========================================
        // SAVE TOKEN TO DATABASE
        // ==========================================

        $insertId = $this->refreshTokenModel->insert([
            'user_id' => 1,
            'token' => $token,
            'expires_at' => $expiresAt,
            'jti' => $jti
        ]);

        // ==========================================
        // VERIFY TOKEN WAS SAVED
        // ==========================================

        $tokens = $this->refreshTokenModel->all();

        $tokenSaved = false;
        $matchedRecord = null;

        foreach ($tokens as $record) {

            if (
                is_array($record) &&
                isset($record['token']) &&
                hash_equals($record['token'], $token)
            ) {
                $tokenSaved = true;
                $matchedRecord = $record;
                break;
            }
        }

        // ==========================================
        // SUCCESS RESPONSE
        // ==========================================

        echo json_encode([
            'status' => true,
            'message' => 'Login successful.',
            'token' => $token,
            'expires_at' => $expiresAt,
            'insert_id' => $insertId,
            'token_saved' => $tokenSaved,
            'total_tokens' => count($tokens),
            'matched_record' => $matchedRecord
        ]);
    }

    // ==========================================
    // POST /api/logout
    // ==========================================
    public function logout()
    {
        $this->setCorsHeaders();

        header('Content-Type: application/json');

        $token = $this->getBearerToken();

        if (!$token) {
            http_response_code(401);

            echo json_encode([
                'status' => false,
                'message' => 'Authentication token is required.'
            ]);

            return;
        }

        $tokenRecord = $this->findToken($token);

        if (!$tokenRecord) {
            http_response_code(401);

            echo json_encode([
                'status' => false,
                'message' => 'Invalid or expired token.'
            ]);

            return;
        }

        $this->refreshTokenModel->delete($tokenRecord['id']);

        echo json_encode([
            'status' => true,
            'message' => 'Logout successful.'
        ]);
    }

    // ==========================================
    // GET BEARER TOKEN
    // ==========================================
    private function getBearerToken()
    {
        $headers = function_exists('getallheaders')
            ? getallheaders()
            : [];

        $authorization = '';

        foreach ($headers as $key => $value) {

            if (strtolower($key) === 'authorization') {
                $authorization = $value;
                break;
            }
        }

        if (
            !$authorization &&
            isset($_SERVER['HTTP_AUTHORIZATION'])
        ) {
            $authorization = $_SERVER['HTTP_AUTHORIZATION'];
        }

        if (
            !$authorization &&
            isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])
        ) {
            $authorization = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }

        if (
            !$authorization &&
            function_exists('apache_request_headers')
        ) {
            $apacheHeaders = apache_request_headers();

            foreach ($apacheHeaders as $key => $value) {

                if (strtolower($key) === 'authorization') {
                    $authorization = $value;
                    break;
                }
            }
        }

        if (
            $authorization &&
            preg_match(
                '/Bearer\s+(.+)/i',
                $authorization,
                $matches
            )
        ) {
            return trim($matches[1]);
        }

        return null;
    }

    // ==========================================
    // FIND TOKEN
    // ==========================================
    private function findToken($token)
    {
        $tokens = $this->refreshTokenModel->all();

        foreach ($tokens as $record) {

            if (
                is_array($record) &&
                isset($record['token']) &&
                hash_equals($record['token'], $token)
            ) {

                if (
                    isset($record['expires_at']) &&
                    strtotime($record['expires_at']) > time()
                ) {
                    return $record;
                }

                return null;
            }
        }

        return null;
    }
}

?>