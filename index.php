<?php
header('Content-Type: application/json');

class RobloxAPI {
    private $maxRequestAge = 30; // seconds
    private $rateLimitPerMinute = 60;
    private $logFile = 'api_logs.txt';
    private $allowedGameIds = ['12345', '67890']; // Your game IDs

    private function log($message) {
        $timestamp = date('Y-m-d H:i:s');
        file_put_contents($this->logFile, "[$timestamp] $message\n", FILE_APPEND);
    }

    public function handleRequest() {
        try {
            // Validate game ID
            $gameId = $_SERVER['HTTP_GAME_ID'] ?? '';
            if (!in_array($gameId, $this->allowedGameIds)) {
                return $this->sendError(1004, "Invalid game ID");
            }

            if (!$this->validateTimestamp()) {
                return $this->sendError(1002, "Request expired");
            }

            if (!$this->checkRateLimit()) {
                return $this->sendError(1003, "Rate limit exceeded");
            }

            $inputHash = $_SERVER['HTTP_RILEYYS_'];
            $generatedString = $_SERVER['HTTP_RILEYYS_2'];

            if (!$this->validateHash($inputHash, $generatedString)) {
                return $this->sendError(1001, "Invalid hash");
            }

            $requestData = json_decode(file_get_contents('php://input'), true);
            
            switch($_SERVER['REQUEST_URI']) {
                case '/player/data':
                    return $this->handlePlayerData($requestData);
                case '/verify':
                    return $this->handleVerification($requestData);
                default:
                    return $this->sendError(1005, "Invalid endpoint");
            }
        } catch (Exception $e) {
            $this->log("Error: " . $e->getMessage());
            return $this->sendError(1006, "Internal server error");
        }
    }

    private function validateTimestamp() {
        $timestamp = $_SERVER['HTTP_TIMESTAMP'] ?? 0;
        return (time() - $timestamp) <= $this->maxRequestAge;
    }

    private function checkRateLimit() {
        // Implement rate limiting logic here
        return true;
    }

    private function sendError($code, $message) {
        http_response_code(400);
        return json_encode(['error' => $code, 'message' => $message]);
    }

    private function processRequest() {
        // Process the actual request here
        return json_encode(['status' => 'success']);
    }

    private function handlePlayerData($data) {
        // Validate player data
        if (!isset($data['userId']) || !isset($data['data'])) {
            return $this->sendError(1007, "Invalid player data");
        }

        // Process player data here
        $this->log("Processed data for user: " . $data['userId']);
        
        return json_encode([
            'status' => 'success',
            'timestamp' => time(),
            'message' => 'Player data processed'
        ]);
    }
}

function customHash($str) {
    $seed = 5381;
    $output = "";
    $prime = 31;
    $offset = 0;

    for ($i = 0; $i < strlen($str); $i++) {
        $offset = ($offset + ord($str[$i]) * $prime) % 255;
    }

    for ($i = 0; $i < strlen($str); $i++) {
        $char = ord($str[$i]);
        $seed = (($seed * $prime) ^ ($char * $offset)) % (2 ** 32);
        $offset = ($offset + $char) % 255;
        $output .= chr(($seed % 26) + 97);
    }

    return "gKnoW78niy5BDGx" . $output . "32d6tYQPaZPATHE";
}

function customHashz($str) {
    $seed = 5381;
    $output2 = "";
    $prime = 31;
    $offset = 0;

    for ($i = 0; $i < strlen($str); $i++) {
        $offset = ($offset + ord($str[$i]) * $prime) % 255;
    }

    for ($i = 0; $i < strlen($str); $i++) {
        $char = ord($str[$i]);
        $seed = (($seed * $prime) ^ ($char * $offset)) % (2 ** 32);
        $offset = ($offset + $char) % 255;
        $output2 .= chr(($seed % 26) + 97);
    }

    return $output2;
}

$a = customHash("Hallo");

$b = customHashz("Hallo");

echo "FullHash:  {$a}  |  Input: Hallo  |   Output:  {$b}";

$api = new RobloxAPI();
echo $api->handleRequest();

?>