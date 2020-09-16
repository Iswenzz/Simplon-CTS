<?php

class Database
{
    private ?PDO $DB = null;

    public function __construct(string $user, string $password, string $db = "cts")
    {
        try {
            $this->DB = new PDO("mysql:host=localhost;dbname=$db;port=3306;charset=utf8mb4", $user, $password);
        
            print_r("$db Connected!");
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
        $req = $this->DB->prepare("SELECT * FROM :tab");
        
        // execution
        $req->execute(["tab" => $table]);

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}
