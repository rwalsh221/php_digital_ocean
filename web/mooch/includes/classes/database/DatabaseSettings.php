<?php 
class DatabaseSettings {

    private $servername;
    private $databaseName;
    private $username;
    private $password;
    private $port;

    private function setDbVar() {
        if (getenv('DATABASE_URL')) {

            $servername = getenv('DATABASE_URL');
            $components = parse_url($servername);
            // var_dump($components);
            
            $this->servername = $components['host'];
            $this->username = $components['user'];
            $this->password = $components['pass'];
            $this->databaseName = substr($components['path'], 1);
            $this->port = $components['port'];

        } else {
            $this->servername = 'localhost';
            $this->databaseName = 'mooch';
            $this->username = 'richardmsi';
            $this->password = 'Polly11@Polly11';
            $this->port = 80;
        }
    }

    public function databaseConnect() {
        $this->setDbVar();
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
        $this->setDbVar();
        try {
            $dbConn = new PDO("mysql:host=$this->servername:$this->port;dbname=$this->databaseName", $this->username, $this->password);
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
        $this->setDbVar();
        try {
            $dbConn = new PDO("mysql:host=$this->servername:$this->port;dbname=$this->databaseName", $this->username, $this->password);
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

    
}
?>