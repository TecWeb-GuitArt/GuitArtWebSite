<?php 
namespace DB;
class DBAccess {
    private const HOST_DB = "127.0.0.1";
    private const USERNAME = "nfasolo";
    private const PASSWORD = "iaW4lexa9neereeg";
    private const DATABASE_NAME = "nfasolo";
    
    private $connection;

    public function openConnection() {
        mysqli_report(MYSQLI_REPORT_ERROR);
        $this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);

        if (mysqli_connect_errno()) {
            return false;
        }
        else {
            return true;
        }
    }

    public function getGuitars() {
        $query = "SELECT * FROM guitars ORDER BY ID ASC";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in openDBConnection: " . mysqli_error($this->connection));

        if (mysqli_num_rows($queryResult) == 0) {
            return null;
        }
        else {
            $result = array();
            while ($riga = mysqli_fetch_assoc($queryResult)) {
                array_push($result, $riga);
            }
            $queryResult->free();
            return $result;
        }
    }

    public function getGuitar($guitar_id) {
        $query = "SELECT * FROM guitars WHERE ID = $guitar_id";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in openDBConnection: " . mysqli_error($this->connection));

        if (mysqli_num_rows($queryResult) == 0) {
            return null;
        }
        else {
            $result = mysqli_fetch_assoc($queryResult);
            $queryResult->free();
            return $result;
        }
    }

    public function insertNewUser($username, $pw_hash) {
        $query = "INSERT INTO users (username, pw_hash, role) VALUES (\"$username\", \"$pw_hash\", \"guest\")";

        $queryOK = mysqli_query($this->connection, $query) or die(mysqli_error($this->connection));
        if (mysqli_affected_rows($this->connection) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function updatePassword($user, $pw_hash) {
        $query = "UPDATE users SET pw_hash = \"$pw_hash\" WHERE username = \"$user\"";

        $queryOK = mysqli_query($this->connection, $query) or die(mysqli_error($this->connection));
        if (mysqli_affected_rows($this->connection) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function deleteUser($user) {
        $query = "DELETE FROM users WHERE username = \"$user\"";

        $queryOK = mysqli_query($this->connection, $query) or die(mysqli_error($this->connection));
        if (mysqli_affected_rows($this->connection) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function getUserRole($user) {
        $query = "SELECT role FROM users WHERE username = \"$user\"";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in openDBConnection: " . mysqli_error($this->connection));

        if (mysqli_num_rows($queryResult) == 0) {
            return null;
        }
        else {
            $result = mysqli_fetch_assoc($queryResult);
            $queryResult->free();
            return $result['role'];
        }
    }

    public function insertNewGuitar($model, $brand, $color, $price, $type, $strings, $frets, $body, $fretboard, $pickupConf, $pickupType, $alt, $description) {
        $id = $this->getLastID() + 1;
        $query = "INSERT INTO guitars (ID, Model, Brand, Color, Price, Type, Strings, Frets, Body, Fretboard, Pickup_Configuration, Pickup_Type, Alt, Description)
                  VALUES ($id, \"$model\", \"$brand\", \"$color\", \"$price\", \"$type\", $strings, $frets, \"$body\", \"$fretboard\", \"$pickupConf\", \"$pickupType\", \"$alt\", \"$description\")";

        $queryOK = mysqli_query($this->connection, $query) or die(mysqli_error($this->connection));
        if (mysqli_affected_rows($this->connection) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function deleteGuitar($guitar_id) {
        $query = "DELETE FROM guitars WHERE ID = $guitar_id";

        $queryOK = mysqli_query($this->connection, $query) or die(mysqli_error($this->connection));
        if (mysqli_affected_rows($this->connection) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function getLastID() { // NUOVA
        $query = "SELECT max(ID) FROM guitars";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in openDBConnection: " . mysqli_error($this->connection));

        if (mysqli_num_rows($queryResult) == 0) {
            return -1;
        }
        else {
            $row = mysqli_fetch_array($queryResult);
            $queryResult->free();
            return $row[0];
        }
    }

    public function addToFavourites($user, $guitar_id) {
        $query = "INSERT INTO favourites (user_id, guitar_id) VALUES (\"$user\", \"$guitar_id\")";

        $queryOK = mysqli_query($this->connection, $query) or die(mysqli_error($this->connection));
        if (mysqli_affected_rows($this->connection) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function removeFromFavourites($user, $guitar_id) {
        $query = "DELETE FROM favourites WHERE (user_id, guitar_id) = (\"$user\", $guitar_id)";

        $queryOK = mysqli_query($this->connection, $query) or die(mysqli_error($this->connection));
        if (mysqli_affected_rows($this->connection) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function getFavourites($user) {
        $query = "SELECT * FROM favourites INNER JOIN guitars ON guitar_id = ID WHERE user_id = \"$user\"";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in openDBConnection: " . mysqli_error($this->connection));

        if (mysqli_num_rows($queryResult) == 0) {
            return null;
        }
        else {
            $result = array();
            while ($riga = mysqli_fetch_assoc($queryResult)) {
                array_push($result, $riga);
            }
            $queryResult->free();
            return $result;
        }
    }

    public function checkFavourite($user, $guitar_id) {
        $query = "SELECT * FROM favourites WHERE user_id = \"$user\" AND guitar_id = $guitar_id";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in openDBConnection: " . mysqli_error($this->connection));

        if (mysqli_num_rows($queryResult) == 0) {
            return false;
        }
        else {
            $queryResult->free();
            return true;
        }
    }

    public function verifyLogin($username, $password) {
        $query = "SELECT username, pw_hash FROM users WHERE username = \"$username\"";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in openDBConnection: " . mysqli_error($this->connection));

        if (mysqli_num_rows($queryResult) == 0) {
            return false;
        }
        else {
            $result = mysqli_fetch_assoc($queryResult);
            $queryResult->free();
            if (password_verify($password,$result['pw_hash'])) {
                return true;
            }
            else {
                return false;
            }
        }
    }

    public function checkAlreadyExistingUser($user) {
        $query = "SELECT * FROM users WHERE username = \"$user\"";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in openDBConnection: " . mysqli_error($this->connection));

        if (mysqli_num_rows($queryResult) == 0) {
            return false; // email non presente nel sistema
        }
        else {
            $queryResult->free();
            return true; // email presente nel sistema
        }
    }

    public function closeConnection() {
        mysqli_close($this->connection);
    }
}
?>