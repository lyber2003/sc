<?php

//TODO: refactor env detection to request middleware
//TODO:

{
    $hostname = gethostname(); // test.soscredit -> ts, dev-soscredit -> vagrant, soscredit.com -> prod and temp
    $env_dir = dirname(__DIR__);
    $baseName = basename($env_dir);
    $env_file = '.env';
    $environment = false;

    $envPath = realpath(__DIR__ . '/env-app/');

    switch ($hostname) {
        case 'soscredit-test':
            $environment = 'test';

            break;
        case 'soscredit-prod':
            // we are on production machine where also temp version reside

            // NOTE: we assume that any unknown environment is production, so no need to set it here implicitly
            $environment = 'prod';

            break;
        case 'soscredit-dev':
            $environment = 'dev';
            break;

        default;
            $environment = 'dev';
            break;
    }

    if (isset($_SERVER['HTTP_HOST'])) {
        switch ($_SERVER['HTTP_HOST']) {
            case 'st.soscredit.com':
                $environment = 'st';
                break;
        }
    }

    if (!$environment) {
        throw new \Exception('Environment not set');
    }

    $envPath = $envPath.'/'.$environment;
    $envFiles = [];
    foreach (scandir($envPath) as $filename) {
        if (in_array($filename, ['.', '..'])) {
            continue;
        }

        $envFiles[] = $filename;
    }

    if (!$envFiles) {
        throw new \Exception('Environment config files not found');
    }

    foreach ($envFiles as $envFile) {
        $dotenv = new \Dotenv\Dotenv($envPath, $envFile);
        $dotenv->load();
    }
}