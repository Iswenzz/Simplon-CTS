<?php

class Database
{
    private ?PDO $DB = null;

    public function __construct(string $user, string $password, string $db, bool $debug = false)
    {
        try {
            $this->DB = new PDO("mysql:host=localhost;dbname=$db;port=3306;charset=utf8mb4", $user, $password);
            
            if ($debug) {
                print_r("Connected to $db! <br/>");
            }
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * Execute a SELECT query to the chosen $table, for the chosen $columns (optional), with the chosen $conditions (optional).
     *
     * @param string $table The name of the table.
     * @param array $columns The list of columns to be fetched : ["id", "type", etc.]
     * @param array $conditions The list of conditions to check :
     * [
     * [opBool=>"", col=>"id", opMath=>">", val=>"5"],
     * [opBool=>"AND", col=>"type", opMath=>"<>", val=>"stable"]
     * ]
     * @return array Array of resulting rows, with each row being an array with the columns names as indexes.
     */
    public function Fetch(string $table, array $columns = ["*"], array $conditions = []): array
    {
        // prepare query string for the columns (select ...)
        $columnsString = count($columns) == 1 ? $columns[0] : implode(", ", $columns);

        // prepare query string for the conditions (where ...)
        if (count($conditions) == 0) {
            $conditionsString = "";
        } else {
            $conditionsString = "WHERE ";
            
            // get all components of each condition
            foreach ($conditions as list($opBool, $col, $opMath, $val)) {
                $conditionsString .= " $opBool $col $opMath $val";
            }
        }

        // prepare the query
        $req = $this->DB->prepare("SELECT :cols FROM :tab :conds");
        
        // execution
        $req->execute([
            "cols" => $columnsString,
            "tab" => $table,
            "conds" => $conditionsString]);

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Execute a SELECT query to the chosen $table, in order to get ALL data.
     *
     * @param string $table The name of the table.
     * @return array Array of resulting rows, with each row being an array with the columns names as indexes.
     */
    public function FetchAll(string $table): array
    {
        // prepare the query
        $req = $this->DB->prepare("SELECT * FROM $table");
        // $req->debugDumpParams(); // debug
        // execution
        $req->execute();

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * TODO :
     * TEMPORARY FUNCTION
     * TO BE DELETED when DAO is functionnal
     */
    public function createAdmin(string $name, string $firstname, string $mail, string $hashedPwd, string $salt): bool
    {
        $req = $this->DB->prepare(
            "INSERT INTO Admin (nomAdmin, prenomAdmin, mailAdmin, mdpAmin, sel, dateCreationAdmin) VALUES
            (:nomAdmin, :prenomAdmin, :mailAdmin, :mdpAmin, :sel, NOW())"
        );

        $values = [
            "nomAdmin" => $name,
            "prenomAdmin" => $firstname,
            "mailAdmin" => $mail,
            "mdpAmin" => $hashedPwd,
            "sel" => $salt
        ];

        return $req->execute($values);
    }
}
