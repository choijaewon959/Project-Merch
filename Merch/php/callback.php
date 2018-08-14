<?php
  session_start();
  require '../Facebook/autoload.php';
  $fb = new Facebook\Facebook([
    'app_id' => '237128450465536', // Replace {app-id} with your app id
    'app_secret' => '3c933211b834da598afc32c9774c0d29',
    'default_graph_version' => 'v3.1',
    ]);

  $helper = $fb->getRedirectLoginHelper();

  try {
    $accessToken = $helper->getAccessToken();
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }

  if (! isset($accessToken)) {
    if ($helper->getError()) {
      header('HTTP/1.0 401 Unauthorized');
      echo "Error: " . $helper->getError() . "\n";
      echo "Error Code: " . $helper->getErrorCode() . "\n";
      echo "Error Reason: " . $helper->getErrorReason() . "\n";
      echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
      header('HTTP/1.0 400 Bad Request');
      echo 'Bad request';
    }
    exit;
  }

  // Logged in
  echo '<h3>Access Token</h3>';
  var_dump($accessToken->getValue());
?>
