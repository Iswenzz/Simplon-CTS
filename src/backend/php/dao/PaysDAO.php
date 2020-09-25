<?php
require_once __DIR__ . "/DAO.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../model/Pays.php";

class PaysDAO implements DAO
{
    public const SELECT_QUERY = "SELECT codePays, libellePays from Pays";
    public const SELECT_ONE_QUERY = "SELECT codePays, libellePays from Pays WHERE codePays = :code";
    public const ADD_QUERY = "INSERT INTO Pays (libellePays) VALUES (:libelle)";
    public const DELETE_QUERY = "DELETE FROM Pays WHERE codePays = :code";
    public const UPDATE_QUERY = "UPDATE Pays SET libellePays = :libelle WHERE codePays = :code";

    /**
     * Fetch all rows to get all Pays objects.
     * @return Pays[]
     */
    public function getAll(): array
    {
        $payss = [];
        $stmt = DatabaseFactory::getConnection()->prepare(PaysDAO::SELECT_QUERY);
        $stmt->execute();
        
        while ($row = $stmt->fetch()) {
            $pays = new Pays(
                (int)$row["codePays"],
                $row["libellePays"]
            );
            $payss[] = $pays;
        }
        return $payss;
    }

    /**
     * Get a pays from its primary key.
     * @param int $code - The primary key code.
     * @return Pays|null
     */
    public function get($code): ?Pays
    {
        $stmt = DatabaseFactory::getConnection()->prepare(PaysDAO::SELECT_ONE_QUERY);
        $stmt->execute([
            "code" => $code
        ]);

        if ($row = $stmt->fetch()) {
            return new Pays(
                (int)$row["codePays"],
                $row["libellePays"]
            );
        }
        return null;
    }

    /**
     * Update a pays row.
     * @param Pays $pays - model
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function update($pays): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(PaysDAO::UPDATE_QUERY);
        return $stmt->execute([
            ":code" => $pays->getCode(),
            ":libelle" => $pays->getLibelle()
        ]);
    }

    /**
     * Delete a pays row.
     * @param Pays $pays - model
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function delete($pays): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(PaysDAO::DELETE_QUERY);
        return $stmt->execute([
            ":code" => $pays->getCode()
        ]);
    }

    /**
     * Add a new pays row.
     * @param Pays $pays - model
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function add($pays): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(PaysDAO::ADD_QUERY);
        $res = $stmt->execute([
            ":code" => $pays->getCode(),
            ":libelle" => $pays->getLibelle()
        ]);
        if ($pays->getCode() == null) {
            $pays->setCode(DatabaseFactory::getConnection()->lastInsertId());
        }
        return $res;
    }

    /**
     * Get the DAO class name.
     */
    public function getClassName(): string
    {
        return get_class($this);
    }
}