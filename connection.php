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

    public function getGuitar($ID) {
        $query = "SELECT * FROM guitars WHERE ID = $ID";
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

    public function insertNewUser($username, $email, $pw_hash) {
        $query = "INSERT INTO users (username, email, pw_hash, role) VALUES (\"$username\", \"$email\", \"$pw_hash\", \"guest\")";

        $queryOK = mysqli_query($this->connection, $query) or die(mysqli_error($this->connection));
        if (mysqli_affected_rows($this->connection) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function updateUsername($email, $username) {
        $query = "UPDATE users SET username = $username WHERE email = $email";

        $queryOK = mysqli_query($this->connection, $query) or die(mysqli_error($this->connection));
        if (mysqli_affected_rows($this->connection) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function updatePassword($email, $pw_hash) {
        $query = "UPDATE users SET pw_hash = $pw_hash WHERE email = $email";

        $queryOK = mysqli_query($this->connection, $query) or die(mysqli_error($this->connection));
        if (mysqli_affected_rows($this->connection) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function deleteUser($email) {
        $query = "DELETE FROM users WHERE email = $email";

        $queryOK = mysqli_query($this->connection, $query) or die(mysqli_error($this->connection));
        if (mysqli_affected_rows($this->connection) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function insertNewGuitar() {

    }

    public function deleteGuitar($ID) {
        $query = "DELETE FROM guitars WHERE ID = $ID";

        $queryOK = mysqli_query($this->connection, $query) or die(mysqli_error($this->connection));
        if (mysqli_affected_rows($this->connection) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function addToFavourites($user_id, $guitar_id) {
        $query = "INSERT INTO favourites (user_id, guitar_id) VALUES (\"$user_id\", \"$guitar_id\")";

        $queryOK = mysqli_query($this->connection, $query) or die(mysqli_error($this->connection));
        if (mysqli_affected_rows($this->connection) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function removeFromFavourites($user_id, $guitar_id) {
        $query = "DELETE FROM favourites WHERE (user_id, guitar_id) = ($user_id, $guitar_id)";

        $queryOK = mysqli_query($this->connection, $query) or die(mysqli_error($this->connection));
        if (mysqli_affected_rows($this->connection) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function getFavourites($email) {
        $query = "SELECT * FROM favourites INNER JOIN guitars ON guitar_id = ID WHERE user_id = $email";
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

    public function verifyLogin($email, $pw_hash) {
        $query = "SELECT email, pw_hash FROM users WHERE email = $email";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in openDBConnection: " . mysqli_error($this->connection));

        if (mysqli_num_rows($queryResult) == 0) {
            return false;
        }
        else {
            $result = mysqli_fetch_assoc($queryResult);
            $queryResult->free();
            if (password_verify($result['pw_hash'], $pw_hash)) {
                return true;
            }
            else {
                return false;
            }
        }
    }

    public function closeConnection() {
        mysqli_close($this->connection);
    }
}
?>