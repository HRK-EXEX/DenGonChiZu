<?php
    const SERVER = "mysql305.phy.lolipop.lan";
    const DBNAME = "LAA1517436-linedwork";
    const USER = "LAA1517436";
    const PASS = "hyperBassData627";
    const DBINFO = 'mysql:host='.SERVER.';dbname='.DBNAME.';charset=utf8';                
    $db = new PDO(DBINFO, USER, PASS);

	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>



<?php
class Database {
    private $conn;

    public function connect() {
        try {
            $this->conn = new PDO('mysql:host=mysql305.phy.lolipop.lan;dbname=LAA1517436-linedwork;charset=utf8', 'LAA1517436', 'hyperBassData627');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
        return $this->conn;
    }
}
?>
