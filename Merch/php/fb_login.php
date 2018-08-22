<?php
  session_start();
  require '../Facebook/autoload.php';
  $fb = new Facebook\Facebook([
    'app_id' => '237128450465536', // Replace {app-id} with your app id
    'app_secret' => '3c933211b834da598afc32c9774c0d29',
    'default_graph_version' => 'v3.1',
    ]);

  $helper = $fb->getRedirectLoginHelper();

  $permissions = ['email']; // Optional permissions
  $loginUrl = $helper->getLoginUrl('https://wemerch.hk/php/fb_callback.php', $permissions);
  header("Location:".$loginUrl);
?>
