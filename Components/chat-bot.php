<?php 
include '../db_connection.php';


// Example user_id (replace with $_SESSION['user_id'] in your real project)
$user_id = $_SESSION['user_id'];

$response = "";
$message = "";

// When user sends a message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);

    // Search keyword in chatbot_responses
    $sql = "SELECT response FROM chatbot_responses  WHERE ? LIKE CONCAT('%', keyword, '%')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $message);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $response = $row['response'];
    } else {
        $response = "Sorry, I don’t understand it yet.";
    }

    // Save conversation history
    $save = $conn->prepare("INSERT INTO chatbot_history (user_id, prompt, response) VALUES (?, ?, ?)");
    $save->bind_param("iss", $user_id, $message, $response);
    $save->execute();


    header("Location: " . $_SERVER['PHP_SELF'] . "?open=1");
    exit();

    $conn->close();
}

// Fetch chat history for this user
$history_sql = "SELECT prompt, response FROM chatbot_history WHERE user_id = ? ORDER BY id ASC";
$history_stmt = $conn->prepare($history_sql);
$history_stmt->bind_param("i", $user_id);
$history_stmt->execute();
$chat_history = $history_stmt->get_result();




?>
    


    <!-- Floating Chat Icon -->
    <button id="chat-icon">💬</button>

    <div id="chat-box">
        <div class="chat-header">
            <p>Clarity Bot</p>
            <button class="close-btn" id="close-btn">X</button>
        </div>
        

        <div class="chat-container" id="chat-container">
            <div class="response">
                    <strong>🤖:</strong> Hi there, How can I help you?
                </div>
            <?php while ($row = $chat_history->fetch_assoc()): ?>
                <div class="message" >
                    <strong></strong> <?php echo htmlspecialchars($row['prompt']); ?>
                </div>
                <div class="response">
                    <strong>🤖:</strong> <?php echo htmlspecialchars($row['response']); ?>
                </div>
            <?php endwhile; ?>
        </div>

        <form method="POST" class="input-message" autocomplete="off">
            <input type="text" name="message" placeholder="Type a message..." required />
            <button type="submit">Send</button>
        </form>
    </div>

    


