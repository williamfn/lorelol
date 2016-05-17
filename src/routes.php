<?php
// Home page route
$app->get('/', function ($request, $response) {
    $filePath = getFilePath($this->get('settings'));
    return $this->renderer->render($response, $filePath.'/home.html', []);
});

// Champions route
$app->get('/champion/{champion}', function ($request, $response, $args) {
    $filePath = getFilePath($this->get('settings'));
    return $this->renderer->render($response, $filePath.'/'.$args['champion'].'.html', $args);
});

// Set language when change the dropdown
$app->post('/ajax/changeLanguage', function ($request) {
    $_SESSION['lang'] = $request->getParsedBodyParam('region');
    echo true;
});

// This always set the default language to english in case the user has cookies/javascript disabled
function getFilePath($settings)
{
    if (empty($_SESSION['lang'])) {
        return $settings['actual_patch'].'/'.$settings['default_region'];
    }
    return $settings['actual_patch'].'/'.$_SESSION['lang'];
}

// Sample log message
//$this->logger->info("Slim-Skeleton '/' route");
