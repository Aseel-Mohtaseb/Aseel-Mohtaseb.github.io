<?php

function getInstagramReelVideo($reelUrl) {
    echo 'reelUrl' . '<br>' . $reelUrl;
    echo "<br>";
    
    // Initialize a cURL session
    $ch = curl_init();

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $reelUrl);

    // Return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Set User Agent to avoid 403 Forbidden response
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3');

    // Execute the cURL session
    $response = curl_exec($ch);

    // Close cURL session
    curl_close($ch);

    echo 'response:' . $response . '<br>';
    // echo 'Response: ' . htmlspecialchars($response) . '<br>';


    // Check if the response is empty
    if (empty($response)) {
        return false;
    }

    // Use regex to extract the video URL
    if (preg_match('/"video_url":"(.*?)"/', $response, $matches)) {
        // Decode the URL
        $videoUrl = str_replace('\u0026', '&', $matches[1]);
        echo 'videoUrl: ' . $videoUrl;
        return $videoUrl;
    }else {
        echo 'not matching' . '<br>';
    }

    return false;
}

function downloadVideo($videoUrl, $savePath) {
    // Initialize a cURL session
    $ch = curl_init();

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $videoUrl);

    // Return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Set User Agent to avoid 403 Forbidden response
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3');

    // Execute the cURL session
    $videoData = curl_exec($ch);

    // Close cURL session
    curl_close($ch);

    // Save the video to a file
    file_put_contents($savePath, $videoData);
}

// Example usage
$reelUrl = 'https://www.instagram.com/reel/C8FWCM9oEaf/';
$videoUrl = getInstagramReelVideo($reelUrl);

if ($videoUrl) {
    // downloadVideo($videoUrl, 'video.mp4');
    // echo "Video downloaded successfully!";
    echo 'videoUrl' . $videoUrl;
} else {
    echo "Failed to retrieve the video URL.";
}
?>
