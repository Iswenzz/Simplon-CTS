<?php
require_once __DIR__ . "/DAO.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../model/Specialite.php";

class SpecialiteDAO implements DAO
{
    public const SELECT_QUERY = "SELECT codeSpecialite, libelleSpecialite, codeTypeMission, descSpecialite from Specialite";
    public const SELECT_ONE_QUERY = "SELECT codeSpecialite, libelleSpecialite, codeTypeMission, descSpecialite from Specialite WHERE codeSpecialite = :code";
    public const ADD_QUERY = "INSERT INTO Specialite (libelleSpecialite, codeTypeMission, descSpecialite) VALUES (:libelle, :codeTM, :descript)";
    public const DELETE_QUERY = "DELETE FROM Specialite WHERE codeSpecialite = :code";
    public const UPDATE_QUERY = "UPDATE Specialite SET libelleSpecialite = :libelle, codeTypeMission = :codeTM, descSpecialite = :descript WHERE codeSpecialite = :code";

    /**
     * Fetch all rows to get all Specialite objects.
     * @return Specialite[]
     */
    public function getAll(): array
    {
        $specialites = [];
        $stmt = DatabaseFactory::getConnection()->prepare(SpecialiteDAO::SELECT_QUERY);
        $stmt->execute();
        
        while ($row = $stmt->fetch()) {
            $specialite = new Specialite(
                (int)$row["codeSpecialite"],
                $row["libelleSpecialite"],
                (int)$row["codeTypeMission"],
                $row["descSpecialite"]
            );
            $specialites[] = $specialite;
        }
        return $specialites;
    }

    /**
     * Get a specialite from its primary key.
     * @param int $code - The primary key code.
     * @return Specialite|null
     */
    public function get($code): ?Specialite
    {
        $stmt = DatabaseFactory::getConnection()->prepare(SpecialiteDAO::SELECT_ONE_QUERY);
        $stmt->execute([
            "code" => $code
        ]);

        if ($row = $stmt->fetch()) {
            return new Specialite(
                (int)$row["codeSpecialite"],
                $row["libelleSpecialite"],
                (int)$row["codeTypeMission"],
                $row["descSpecialite"]
            );
        }
        return null;
    }

    /**
     * Update a specialite row.
     * @param Specialite $specialite - model
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function update($specialite): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(SpecialiteDAO::UPDATE_QUERY);
        return $stmt->execute([
            ":code" => $specialite->getCode(),
            ":libelle" => $specialite->getLibelle(),
            ":codeTM" => $specialite->getCodeTypeMission(),
            ":descript" => $specialite->getDescription()
        ]);
    }

    /**
     * Delete a specialite row.
     * @param Specialite $specialite - model
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function delete($specialite): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(SpecialiteDAO::DELETE_QUERY);
        return $stmt->execute([
            ":code" => $specialite->getCode()
        ]);
    }

    /**
     * Add a new specialite row.
     * @param Specialite $specialite - model
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function add($specialite): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(SpecialiteDAO::ADD_QUERY);
        $res = $stmt->execute([
            ":code" => $specialite->getCode(),
            ":libelle" => $specialite->getLibelle(),
            ":codeTM" => $specialite->getCodeTypeMission(),
            ":descript" => $specialite->getDescription()
        ]);
        if ($specialite->getCode() == null) {
            $specialite->setCode(DatabaseFactory::getConnection()->lastInsertId());
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