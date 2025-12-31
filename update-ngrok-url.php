<?php
/**
 * Script to automatically update APP_URL with current ngrok URL
 * Run this before starting the server when using ngrok
 * Usage: php update-ngrok-url.php
 */

try {
    // Get ngrok URL from ngrok API
    $ngrokApi = 'http://127.0.0.1:4040/api/tunnels';
    
    $response = @file_get_contents($ngrokApi);
    
    if (!$response) {
        echo "❌ Ngrok not running or API not accessible at $ngrokApi\n";
        exit(1);
    }
    
    $data = json_decode($response, true);
    
    if (empty($data['tunnels'])) {
        echo "❌ No ngrok tunnels found\n";
        exit(1);
    }
    
    // Find HTTPS tunnel
    $ngrokUrl = null;
    foreach ($data['tunnels'] as $tunnel) {
        if (strpos($tunnel['public_url'], 'https') === 0) {
            $ngrokUrl = $tunnel['public_url'];
            break;
        }
    }
    
    if (!$ngrokUrl) {
        echo "❌ No HTTPS tunnel found\n";
        exit(1);
    }
    
    // Update .env file
    $envPath = __DIR__ . '/.env';
    $envContent = file_get_contents($envPath);
    
    // Replace or add APP_URL
    if (preg_match('/^APP_URL=/m', $envContent)) {
        $envContent = preg_replace('/^APP_URL=.*/m', 'APP_URL=' . $ngrokUrl, $envContent);
    } else {
        $envContent = preg_replace('/^(APP_URL=)/', 'APP_URL=' . $ngrokUrl . "\n", $envContent);
    }
    
    file_put_contents($envPath, $envContent);
    
    echo "✅ APP_URL updated to: $ngrokUrl\n";
    echo "Run: php artisan config:clear\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
