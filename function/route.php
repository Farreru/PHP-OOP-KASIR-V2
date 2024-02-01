<?php
class Route
{
    private $BASE_URL;
    private $APP_FOLDER;

    public function __construct()
    {
        $configContents = file_get_contents(__DIR__ . '/../config.json');
        $configData = json_decode($configContents, true);

        if ($configData !== null && isset($configData['BASE_URL'])) {
            $this->BASE_URL = $configData['BASE_URL'];
            $this->APP_FOLDER = $configData['APP_FOLDER'];
        } else {
            throw new Exception("Error reading baseURL from config.json");
        }
    }

    public function getBaseURL()
    {
        return $this->BASE_URL;
    }

    public function getAppFolder()
    {
        return $this->APP_FOLDER;
    }
}
