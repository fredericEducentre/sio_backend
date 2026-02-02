<?php
// API Documentation for Developers

$baseUrl = "http://localhost:8081";

$endpoints = [
    [
        'route' => '/api/users.php',
        'methods' => [
            'GET' => [
                'description' => 'Returns a list of all users.',
                'params' => 'None',
                'response' => 'JSON array of user objects {id, username, email, role}',
                'curl' => "curl -X GET $baseUrl/api/users.php"
            ],
            'POST' => [
                'description' => 'Creates a new user.',
                'params' => 'JSON body: {username, email, password, role}',
                'response' => 'JSON object {success: true, message: "..."}',
                'curl' => "curl -X POST -H \"Content-Type: application/json\" -d '{\"username\":\"newuser\", \"email\":\"test@test.com\", \"password\":\"pass123\", \"role\":\"user\"}' $baseUrl/api/users.php"
            ],
            'DELETE' => [
                'description' => 'Deletes a user by ID.',
                'params' => 'GET parameter ?id=X or JSON body: {id: X}',
                'response' => 'JSON object {success: true, message: "..."}',
                'curl' => "curl -X DELETE \"$baseUrl/api/users.php?id=3\""
            ]
        ]
    ],
    [
        'route' => '/api/posts.php',
        'methods' => [
            'GET' => [
                'description' => 'Returns a list of all forum posts.',
                'params' => 'None',
                'response' => 'JSON array of post objects {id, user_id, username, content, created_at}',
                'curl' => "curl -X GET $baseUrl/api/posts.php"
            ],
            'POST' => [
                'description' => 'Creates a new post.',
                'params' => 'JSON body: {user_id, content}',
                'response' => 'JSON object {success: true, message: "..."}',
                'curl' => "curl -X POST -H \"Content-Type: application/json\" -d '{\"user_id\":1, \"content\":\"Hello World!\"}' $baseUrl/api/posts.php"
            ],
            'DELETE' => [
                'description' => 'Deletes a post by ID.',
                'params' => 'GET parameter ?id=X or JSON body: {id: X}',
                'response' => 'JSON object {success: true, message: "..."}',
                'curl' => "curl -X DELETE \"$baseUrl/api/posts.php?id=1\""
            ]
        ]
    ]
];

if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($endpoints, JSON_PRETTY_PRINT);
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>API Documentation</title>
        <style>
            body { font-family: sans-serif; line-height: 1.6; max-width: 1000px; margin: 2rem auto; padding: 0 1rem; background: #fdfdfd; color: #333; }
            h1 { border-bottom: 2px solid #007bff; padding-bottom: 0.5rem; color: #007bff; }
            .endpoint { background: #fff; padding: 1.5rem; margin-bottom: 2rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border: 1px solid #eee; }
            code { background: #f4f4f4; padding: 0.2rem 0.4rem; border-radius: 3px; font-family: monospace; font-size: 1.1rem; color: #d63384; }
            .method-block { margin-top: 1.5rem; padding: 1rem; border-left: 4px solid #007bff; background: #fafafa; position: relative; }
            .method-name { font-weight: bold; color: #28a745; margin-right: 1rem; font-size: 1.2rem; }
            .description { margin: 0.2rem 0; font-weight: 500; }
            .meta { font-size: 0.95rem; color: #666; margin-top: 0.5rem; }
            .curl-block { background: #2b2b2b; color: #f8f8f2; padding: 1rem; border-radius: 4px; overflow-x: auto; margin-top: 0.8rem; font-family: 'Courier New', Courier, monospace; font-size: 0.9rem; }
            h2 { margin-top: 0; color: #444; }
        </style>
    </head>
    <body>
        <h1>API Documentation</h1>
        <p>This developer documentation covers all available methods for interacting with our platform's API endpoints. Each method includes a <code>curl</code> example for testing.</p>
        
        <?php foreach ($endpoints as $e): ?>
            <div class="endpoint">
                <h2><code><?php echo htmlspecialchars($e['route']); ?></code></h2>
                <?php foreach ($e['methods'] as $name => $m): ?>
                    <div class="method-block">
                        <span class="method-name"><?php echo $name; ?></span>
                        <div class="description"><?php echo htmlspecialchars($m['description']); ?></div>
                        <div class="meta">
                            <strong>Params:</strong> <code><?php echo htmlspecialchars($m['params']); ?></code><br>
                            <strong>Returns:</strong> <code><?php echo htmlspecialchars($m['response']); ?></code>
                        </div>
                        <div class="curl-block">
                            <?php echo htmlspecialchars($m['curl']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <hr>
        <p><small>For JSON format, add <code>?format=json</code> to the URL.</small></p>
    </body>
    </html>
    <?php
}
?>
