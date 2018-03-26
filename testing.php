<?php
require_once "core/bootstrap.php";

class TestFailedException extends Exception
{
}

class TestCase
{
    private $title;

    private $testDetailsList = array();

    private $testFunction;

    public static function createTestCaseWithTestDetails($title, $testDetailsList, $testFunction)
    {
        $instance = new self($title, $testFunction);
        $instance->testDetailsList = $testDetailsList;
        return $instance;
    }

    public function __construct($title, $testFunction)
    {
        $this->title = $title;
        $this->testFunction = $testFunction;
    }

    public function execute()
    {
        try {
            $f = $this->testFunction;
            $f();
            $this->printTestSuccessful();
        } catch (TestFailedException $e) {
            $this->printTestFailed($e->getMessage());
        } catch (PDOException $e) {
            $this->printTestFailed($e->getMessage());
        }
    }

    private function printTestSuccessful()
    {
        echo "<li class='testSuccessful'>$this->title</li>";
        $this->appendTestDetailsList();
    }

    private function printTestFailed($details = null)
    {
        $detailsToPrint = strlen($details) > 0 ? "<br>$details" : "";
        echo "<li class='testFailed'>$this->title$detailsToPrint</li>";
        $this->appendTestDetailsList();
    }

    private function appendTestDetailsList()
    {
        if (is_array($this->testDetailsList) && count($this->testDetailsList) > 0) {
            echo "<ul><li>";
            if ($this->isAssocArray($this->testDetailsList)) {
                echo implode("</li><li>", array_map(
                    function ($v, $k) {
                        return sprintf("%s = '%s'", $k, $v);
                    },
                    $this->testDetailsList,
                    array_keys($this->testDetailsList)
                ));
            } else {
                echo implode("</li><li>", $this->testDetailsList);
            }
            echo "</li></ul>";
        }
    }

    private function isAssocArray(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

}

function routeToUrl($route)
{
    $actualLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $rootLink = str_replace(basename($actualLink), '', $actualLink);
    $url = $rootLink . $route;
    return $url;
}


class PostRequester
{
    private $url;
    private $postParamsMap = array();


    public function __construct($route)
    {
        $this->url = routeToUrl($route);
    }

    public function setPostParams($paramsMap)
    {
        $this->postParamsMap = $paramsMap;
    }

    public function performRequest()
    {
        $options = array(
            // use key 'http' even if you send the request to https://...
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($this->postParamsMap)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($this->url, false, $context);
        if ($result === FALSE) { /* Handle error */
            throw new TestFailedException("Post request was not successful.");
        }
        return $result;
    }
}

class Asserts
{
    public static function amountOfEntriesInContentTable($expectedAmount)
    {
        $amountOfEntries = countContentTableEntries();
        if ($amountOfEntries !== $expectedAmount) {
            throw new TestFailedException("Expected empty content table. But was $amountOfEntries");
        }
    }
}

function okMessage($message)
{
    echo "<li class='testSuccessful'>$message</li>";
}

function notOkMessage($message)
{
    echo "<li class='testFailed'>$message</li>";
}

function executeQuery($query, $params = array(), $dbConnection = null)
{
    if (!$dbConnection) {
        $dbConnection = connectToDatabase();
    }
    $sth = $dbConnection->prepare($query);
    $sth->execute($params);
    return $sth->fetch(PDO::FETCH_ASSOC);
}

function countContentTableEntries()
{
    $result = executeQuery("SELECT COUNT(*) amount from " . CONFIG["nameOfContentTable"]);
    if (!is_array($result)) {
        throw new TestFailedException($result);
    } else {
        return intval($result["amount"]);
    }
}

function executeModifyingQuery($query, $params)
{
    $dbConnection = connectToDatabase();
    $sth = $dbConnection->prepare($query);
    return $sth->execute($params);
}

function deleteDump()
{
    unlink(CONFIG["databaseDumpFileName"]);
}

function readDump()
{
    return file_get_contents(CONFIG["databaseDumpFileName"]);
}

function createDump()
{
    deleteDump();
    $pwdString = strlen(CONFIG["databasePassword"]) > 0 ? " -p" . CONFIG["databasePassword"] : "";
    $command = CONFIG["mysqlDumpExecutable"] . " -u" . CONFIG["databaseUser"] . $pwdString . " --no-create-db " . CONFIG["databaseName"] . " > " . CONFIG["databaseDumpFileName"];
    echo "Command that will be executed on command line:<br><div class=\"alert alert-secondary\" role=\"alert\"><samp>$command</samp></div>";
    shell_exec($command);
    echo "Content of " . CONFIG["databaseDumpFileName"] . " after dump:<br><div class=\"alert alert-secondary\" role=\"alert\"><pre><samp>" . readDump() . "</samp></pre></div>";
}

function restoreDump()
{
    $pwdString = strlen(CONFIG["databasePassword"]) > 0 ? " -p" . CONFIG["databasePassword"] : "";
    $command = CONFIG["mysqlExecutable"] . " -u" . CONFIG["databaseUser"] . $pwdString . " --database=" . CONFIG["databaseName"] . " < " . CONFIG["databaseDumpFileName"];
    echo "Command that will be executed on command line:<br><div class=\"alert alert-secondary\" role=\"alert\"><samp>$command</samp></div>";
    $output = shell_exec($command);
}

function updateSelf()
{
    $path = "http://web.kurse.ict-bz.ch/m307_2/testing.script";
    $newScript = file_get_contents($path);
    if ($newScript === false) {
        notOkMessage("Update failed!");
    } else {
        file_put_contents("testing.php", $newScript);
        okMessage("Downloaded new file from " . $path);
    }
}

function deleteAllRowsInContentTable()
{
    $query = "DELETE FROM " . CONFIG["nameOfContentTable"];
    return executeModifyingQuery($query, array());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Testing</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <style>
        body {
            padding-top: 5rem;
        }

        .starter-template {
            padding: 3rem 1.5rem;
            text-align: center;
        }

        li.testSuccessful {
            /*https://icons8.com/icon*/
            list-style-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAACOSURBVDhPYxgFpAOn2U7izvPdt9nPd1eAChEPQJqd5rtfA2MgGypMHKBIs/18LwmCmu2X+ohAmSiAKM3O8zxMnee7fXOc5+EFFQIDZM0gNlQYE9TX1zM5LXCf6zTf7SfMEKI1w8F/BkagK2aDDAFqSiBNMwwADQFqmum8wP0/6ZphAOwS91ryNNMfMDAAAGd1T8ODFWGUAAAAAElFTkSuQmCC');
        }

        li.testFailed {
            list-style-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAEESURBVDhPY6AJ+Oxoqv3F2azys7PZfBAGsT85mWlBpXGDdy7G/F+czJYCNf0DavqPjMFiTmZLQGqgylEBWLOz6UV0jej4s7PpBayGADUvx6YBKwa6BKoNAkD+Q3b29+LM/z8n98A1gNggMRgfpPaTm7EGVDvQdiezKpgkWMPU3v8g8HNaPxiD2UAxZDVfXEwroNqBoe5sOg9FEohhGkEAxEaX/+xkOheqnQoGkOUFJ9NyqHZgILqYa1IUiCAASkAwBYQw0PkLodoQAJQ4QIkEmwZkjDMhgcAbDzM+UCJB9g5co5PZX5AcSA1UOW4AChNQIAENgmQmJ7Oyj44m6lBpagIGBgA1x4zCophfDAAAAABJRU5ErkJggg==');
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="?">Testing-Overview</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <!--<li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
            </li>-->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">Database '<?= CONFIG["databaseName"] ?>'</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="?f=createDbDump">Create db dump to
                        '<?= CONFIG["databaseDumpFileName"] ?>'</a>
                    <a class="dropdown-item" href="?f=restoreDump">Load db dump from
                        '<?= CONFIG["databaseDumpFileName"] ?>'</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">Manage table '<?= CONFIG["nameOfContentTable"] ?>'</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="?f=deleteAllRowsInContentTable">Delete all rows in
                        '<?= CONFIG["nameOfContentTable"] ?>'</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?f=executeTests">Execute modifying tests</a>
            </li>
        </ul>
        <span class="navbar-text">
                Version 0.6 <a href="?f=update">Update</a>
            </span>
    </div>
</nav>

<main role="main" class="container">

    <?php
    $action = $_GET["f"] ?? "";
    if ($action == "restoreDump") {
        ?>
        <h1>Restore Db Dump</h1>

        <?php
        restoreDump();
    } elseif ($action == "createDbDump") {
        ?>
        <h1>Create Db Dump</h1>

        <?php
        createDump();
    } elseif ($action == "update") {
        updateSelf();
    } elseif ($action == "deleteAllRowsInContentTable") {
        ?>
        <h1>Delete all rows in table <samp><?= CONFIG["nameOfContentTable"] ?></samp></h1>
        <?php
        {
            $result = deleteAllRowsInContentTable();
            if ($result) {
                echo "<ul>";
                okMessage("Table " . CONFIG["nameOfContentTable"] . " is now empty.");
                echo "</ul>";
            } else {
                echo "<ul>";
                notOkMessage("Rows in  " . CONFIG["nameOfContentTable"] . " could not be deleted.");
                echo "</ul>";
            }
        }
    } elseif ($action == "executeTests") {
        ?>
        <h1>Test execution (modifying your database!)</samp></h1>
        <h2>Create new entry</h2>
        <ul>
            <?php
            {

                $route = CONFIG["routes"]["addItemRoute"];
                $requester = new PostRequester($route);

                $data = array(
                    CONFIG["content"]["firstnameField"]["htmlName"] => CONFIG["contentValuesSuccessful"]["firstnameField"],
                    CONFIG["content"]["lastnameField"]["htmlName"] => CONFIG["contentValuesSuccessful"]["lastnameField"],
                    CONFIG["content"]["emailField"]["htmlName"] => CONFIG["contentValuesSuccessful"]["emailField"],
                    CONFIG["content"]["telField"]["htmlName"] => CONFIG["contentValuesSuccessful"]["telField"],
                    CONFIG["content"]["dynamicallyCalculatedField"]["htmlName"] => CONFIG["contentValuesSuccessful"]["dynamicallyCalculatedField"],
                    CONFIG["content"]["choosableItemField"]["htmlName"] => CONFIG["contentValuesSuccessful"]["choosableItemField"]
                );

                $testDetails = array_merge(array("route" => $route), $data);

                (TestCase::createTestCaseWithTestDetails("Adding a new item must be possible with valid inputs.",
                    $testDetails,
                    function () use ($requester, $data) {
                        deleteAllRowsInContentTable();
                        Asserts::amountOfEntriesInContentTable(0);
                        $requester->setPostParams($data);
                        // act
                        $result = $requester->performRequest();
                        echo "<pre>" . htmlentities($result) . "</pre>";
                        // assert
                        Asserts::amountOfEntriesInContentTable(1);
                    }))->execute();
            }


            ?>
        </ul>
        <?php
    } else {
        ?>
        <h1>Testing and Overview</h1>

        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#configDump"
                aria-expanded="false" aria-controls="configDump">
            Show configuration
        </button><br><br>
        <div class="alert alert-secondary collapse" id="configDump" role="alert">
            <pre><?php
                var_dump(CONFIG)
                ?></pre>
        </div>

        <h2>Database dump possible?</h2>
        <ul>
            <?php
            {
                $filename = CONFIG["databaseDumpFileName"];
                (new TestCase("Db dump file must exist at <samp>$filename</samp>.", function () use ($filename) {
                    if (!file_exists($filename)) {
                        throw new TestFailedException();
                    }
                }))->execute();
            }

            {
                $filename = CONFIG["mysqlDumpExecutable"];
                (new TestCase("MySQL dump executable must exist at <samp>$filename</samp>.", function () use ($filename) {
                    if (!file_exists($filename)) {
                        throw new TestFailedException();
                    }
                }))->execute();
            }

            {
                $filename = CONFIG["mysqlExecutable"];
                (new TestCase("MySQL executable must exist at <samp>$filename</samp>.", function () use ($filename) {
                    if (!file_exists($filename)) {
                        throw new TestFailedException();
                    }
                }))->execute();
            }
            ?>
        </ul>

        <h2>Database</h2>
        <ul>
            <?php
            {
                (new TestCase("Connection to database host <samp>" . CONFIG["databaseHost"] . "</samp> must be successful.", function () {
                    connectToDatabase(false);
                }))->execute();
            }

            {
                (new TestCase("Database <samp>" . CONFIG["databaseName"] . "</samp> must exist.", function () {
                    connectToDatabase();
                }))->execute();
            }
            ?>
        </ul>

        <h2>Content Table</h2>
        <ul>
            <?php
            {
                (new TestCase("Content table <samp>" . CONFIG["nameOfContentTable"] . "</samp> must exist.", function () {
                    $result = executeQuery("SHOW TABLES like ?", array(CONFIG["nameOfContentTable"]));
                    if (!is_array($result) || reset($result) !== CONFIG["nameOfContentTable"]) {
                        throw new TestFailedException();
                    }
                }))->execute();
            }

            function executeDatabaseFieldExistenceTest($fieldName)
            {
                $table = CONFIG["nameOfContentTable"];
                (new TestCase("Field <samp>$fieldName</samp> in table <samp>$table</samp> must exist.",
                    function () use ($table, $fieldName) {
                        $result = executeQuery("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?", array(CONFIG["databaseName"], $table, $fieldName));
                        if (!is_array($result) || reset($result) !== $fieldName) {
                            throw new TestFailedException();
                        }
                    }))->execute();
            }

            $firstnameFieldName = CONFIG["content"]["firstnameField"]["databaseName"];
            executeDatabaseFieldExistenceTest($firstnameFieldName);
            $lastnameFieldName = CONFIG["content"]["lastnameField"]["databaseName"];
            if ($firstnameFieldName != $lastnameFieldName) {
                executeDatabaseFieldExistenceTest($lastnameFieldName);
            }

            executeDatabaseFieldExistenceTest(CONFIG["content"]["emailField"]["databaseName"]);
            executeDatabaseFieldExistenceTest(CONFIG["content"]["telField"]["databaseName"]);
            executeDatabaseFieldExistenceTest(CONFIG["content"]["dynamicallyCalculatedField"]["databaseName"]);
            executeDatabaseFieldExistenceTest(CONFIG["content"]["choosableItemField"]["databaseName"]);
            executeDatabaseFieldExistenceTest(CONFIG["content"]["calculatedDateField"]["databaseName"]);
            executeDatabaseFieldExistenceTest(CONFIG["content"]["stateField"]["databaseName"]);

            ?>
        </ul>

        <h2>Routes</h2>
        <ul>
            <?php
            function executeRouteExistenceTest($route)
            {
                $url = routeToUrl($route);
                (new TestCase("Route <samp>$route</samp> (<samp>$url</samp>) for showing all items must exist.",
                    function () use ($url) {
                        if (@file_get_contents($url) === false) {
                            throw new TestFailedException("Could not find the following url: <samp>$url</samp>");
                        }
                    }))->execute();
            }

            executeRouteExistenceTest(CONFIG["routes"]["listItemRoute"]);
            executeRouteExistenceTest(CONFIG["routes"]["addItemRoute"]);
            executeRouteExistenceTest(CONFIG["routes"]["editItemRoute"]);

            ?>
        </ul>
        <?php
    }
    ?>
</main>
</body>
</html>

