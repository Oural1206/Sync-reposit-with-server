<?php
include("https://raw.githubusercontent.com/Oural1206/php-functions/main/allFunctions.php");

function addElementTo($path, $listName) {
    $listName = $listName. "Elem";
    $path = "`$path`";
    if ($GLOBALS[$listName] == "*null*") {
        $GLOBALS[$listName] = "- $path";
    } else {
        $GLOBALS[$listName] = $GLOBALS[$listName]. "
        - $path";
    }
}

function cloneDir($path) {
    $localFile = "public-html/$path";
    $repoFile = $GLOBALS["repository"]. "/$path";
    if (is_dir($repoFile)) {
        if (!file_exists($localFile) && $repoFile != $GLOBALS["repository"]) {
            mkdir($localFile, 0777, true);
            addElementTo($path, "new");
        }
        foreach(scandir($repoFile) as $element) {
            if ($element != "." && $element != "..") {
                cloneDir("$path/$element");
            }
        }
    } else {
        if (file_exists($localFile)) {
            if (filesize($repoFile) != filesize($localFile)) {
                copy($repoFile, $localFile);
                addElementTo($path, "modified");
            }
        } else {
            copy($repoFile, $localFile);
            addElementTo($path, "new");
        }
    }
}

function removeOverflow($path) {
    $localFile = "public-html/$path";
    $repoFile = $GLOBALS["repository"]. "/$path";
    if (file_exists($repoFile)) {
        if (is_dir($localFile)) {
            foreach(scandir($localFile) as $element) {
                if ($element != "." && $element != "..") {
                    removeOverflow("$path/$element");
                }
            }
        }
    } else {
        if (is_dir($localFile)) {
            foreach(scandir($localFile) as $element) {
                if ($element != "." && $element != "..") {
                    unlink("$localFile/$element");
                    addElementTo("$path/$element", "deleted");
                }
            }
            rmdir($localFile);
            addElementTo($path, "deleted");
        } else {
            unlink($localFile);
            addElementTo($localFile, "deleted");
        }
    }
}

$configFile = file_get_contents("config.json");
$config = json_decode($configFile, true);

$link = "https://user:". $config["token"]. "@github.com/". $config["username"]. "/". $config["repositoryName"]. "/archive/refs/heads/". $config["branchName"]. ".zip";
$file = file_put_contents("repository.zip", file_get_contents($link));
$zip = new ZipArchive;
$zip -> open("repository.zip");
$zip -> extractTo(".");
$zip -> close();
remove("repository.zip");

$GLOBALS["repository"] = $config["repositoryName"]. "-". $config["branchName"];

$GLOBALS["newElem"] = "*null*";
$GLOBALS["modifiedElem"] = "*null*";
$GLOBALS["deletedElem"] = "*null*";

cloneDir("");
removeOverflow("");
remove($repository);

sendDiscordWhebhook($config["discordWhebhook"], [
    "embeds" => [
        [
            "title" => "New synchronization",
            "description" => $_SERVER["HTTP_HOST"],
            "color" => 6092745,
            "fields" => [
                [
                    "name" => "__New elements__",
                    "value" => $GLOBALS["newElem"]
                ],
                [
                    "name" => "__Modified elements__",
                    "value" => $GLOBALS["modifiedElem"]
                ],
                [
                    "name" => "__Deleted elements__",
                    "value" => $GLOBALS["deletedElem"]
                ]
            ],
            "timestamp" => date("c", strtotime("now"))
        ]
    ]
]);