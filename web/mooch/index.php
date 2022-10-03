<?php
// phpinfo();
echo 'hello mooch';

class DatabaseSettings {



    private $servername = 'localhost';
    private $databaseName = 'mooch';
    private $username = 'richardmsi';
    private $password = 'Polly11@Polly11';
    private $port = 80;

    public function __construct() {
        if (getenv('DATABASE_URL')) {

            $servername = getenv('DATABASE_URL');
            $components = parse_url($servername);
            
            $this->host = $components['host'];
            $this->username = $components['user'];
            $this->password = $components['pass'];
            $this->dbname = substr($components['path'], 1);
            $this->port = $components['port'];

        }
    }

    public function databaseConnect() {
        try {
            $dbConn = new PDO("mysql:host=$this->servername:$this->port;dbname=$this->databaseName", $this->username, $this->password);
             // set the PDO error mode to exception
            $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbConn;
        } catch (PDOException $e) {
            echo 'connection failed: ' . $e->getMessage();
        }

    }

    protected function getFromDatabase($sql) {
        try {
            $dbConn = new PDO("mysql:host=$this->servername;dbname=$this->databaseName", $this->username, $this->password);
             // set the PDO error mode to exception
            $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $dbPrepare = $dbConn->prepare($sql);
            $dbPrepare->execute();

            $result = $dbPrepare->fetchAll(PDO::FETCH_ASSOC);

            return($result);

            
        } catch (PDOException $e) {
            echo 'connection failed: ' . $e->getMessage();
        }

    }

    protected function insertIntoDatabase($sql) {
        try {
            $dbConn = new PDO("mysql:host=$this->servername;dbname=$this->databaseName", $this->username, $this->password);
             // set the PDO error mode to exception
            $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $dbPrepare = $dbConn->prepare($sql);
            $dbPrepare->execute();

            echo 'database update success';
            http_response_code(200);
            
        } catch (PDOException $e) {
            echo 'connection failed: ' . $e->getMessage();
            http_response_code(404);
        }

    }

    protected function getOneColum($tableName, $columName, $userId ) {
        $sql = "SELECT $columName FROM $tableName WHERE userId='$userId'";
        return $this->getFromDatabase($sql);
    }

    public function test() {
        echo $this->servername;
    }

    
}
$test = new DatabaseSettings();

$test->test()
?>