# Secure Client-Server API Integration
Complete API solution for secure client-server communication.

## 📚 Table of Contents
- [Installation](#installation)
- [Security Features](#security-features) 
- [Usage](#usage)
- [API Endpoints](#api-endpoints)
- [Error Codes](#error-codes)
- [Examples](#examples)

## 🔧 Installation

### Server (PHP)
```bash
git clone https://github.com/yourusername/secure-api
cd secure-api
composer install
```

### Client (Lua)
Copy `connect.lua` to ServerScriptService.

## 🛡️ Security Features
- Custom Hashing Algorithm (256-bit)
- Request Signing
- Rate Limiting (60 req/min)
- IP Whitelist System
- Request Timestamp Validation (30s window)
- Caching System (60s cache)
- Retry Mechanism with Exponential Backoff
- Game ID Verification
- Extensive Logging

## 📝 Usage

### Server Setup
```php
// Adjust config.php
$config = [
    'allowed_games' => ['12345', '67890'],
    'rate_limit' => 60,
    'cache_time' => 60
];
```

### Client Examples

#### Basic Request
```lua
local API = require(game.ServerScriptService.API)

local response = API.secureRequest(
    "https://api.example.com/data",
    "POST",
    {data = "test"}
)
```

#### Send Player Data
```lua
local success = API.sendPlayerData(player, {
    coins = 100,
    inventory = {"item1", "item2"},
    level = 5
})
```

## 🔌 API Endpoints

### /api/verify
Validates API connection
- Method: POST
- Rate Limit: 60/min
- Auth: Required

Request:
```json
{
    "gameId": "12345",
    "timestamp": 1234567890
}
```

Response:
```json
{
    "status": "success",
    "serverTime": 1234567890
}
```

### /api/player/data
Process player data
- Method: POST
- Rate Limit: 60/min
- Auth: Required

Request:
```json
{
    "userId": "123456",
    "data": {
        "coins": 100,
        "inventory": ["item1"]
    }
}
```

## ⚠️ Error Codes
| Code | Description | Solution |
|------|-------------|----------|
| 1001 | Invalid hash | Regenerate hash |
| 1002 | Request expired | Synchronize system time |
| 1003 | Rate limit | Reduce request frequency |
| 1004 | Invalid game ID | Check game ID |
| 1005 | Invalid endpoint | Verify URL |
| 1006 | Server error | Contact support |
| 1007 | Invalid data | Check data format |

## 📋 Logging
Logs stored in `/logs/api.log`:
```log
[2023-10-20 15:30:45] Request received from Game 12345
[2023-10-20 15:30:45] Processing player data for ID: 123456
```

## 🔒 Security Recommendations
1. Secure API key storage
2. Use HTTPS
3. Enable rate limiting
4. Use whitelist system
5. Regular log analysis

## 🔍 Debugging
Enable debug mode:
```php
define('API_DEBUG', true);
```

## 🔑 Custom Hashing System

### Hash Configuration
Customize your hash algorithm:

```php
// In config.php
'hashing' => [
    'prefix' => 'YourPrefix123',    // Custom prefix
    'suffix' => 'YourSuffix456',    // Custom suffix
    'seed' => 1234,                 // Different start seed
    'prime' => 31,                  // Prime number of choice
    'salt' => 'YourSalt789',        // Custom salt
]
```

### Hash Examples

#### 1. Basic Hash
```php
$config['hashing']['prefix'] = 'API';
$config['hashing']['suffix'] = 'KEY';
// Result: API{hash}KEY
```

#### 2. Complex Hash
```php
$config['hashing']['seed'] = 7919;    // Large prime
$config['hashing']['prime'] = 6007;   // Different prime
// Creates more complex hash
```

### Security Guidelines

1. **Prefix/Suffix**
   - Minimum 10 characters
   - Mix numbers and letters
   - Change regularly

2. **Seed & Prime**
   - Use large prime numbers
   - Change periodically
   - Document changes

3. **Salt**
   - Minimum 16 characters
   - Random string
   - Unique per instance

### Hash Migration Steps

1. Create new configuration
2. Generate test hashes
3. Temporarily accept old hashes
4. Gradual migration
5. Invalidate old hashes

### Debugging Hashes

```php
define('HASH_DEBUG', true);
// Shows hash details in log:
// - Used parameters
// - Intermediate hashes
// - Performance metrics
```

## 📊 Hash Statistics
- Average Length: 32-64 characters
- Collision Rate: <0.0001%
- Generation Time: <1ms

## 📞 Support
For questions: {discord: TheSwissDeveloper}

## 📄 License
MIT License
