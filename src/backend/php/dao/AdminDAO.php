<?php
require_once __DIR__ . "/DAO.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../model/Admin.php";

class AdminDAO implements DAO
{
    public const SELECT_QUERY = "SELECT mailAdmin, nomAdmin, prenomAdmin, dateCreationAdmin, mdpAdmin, apiKey, expirationApiKey from Admin";
    public const SELECT_ADMIN_QUERY = "SELECT mailAdmin, nomAdmin, prenomAdmin, dateCreationAdmin, mdpAdmin, apiKey, expirationApiKey from Admin WHERE mailAdmin = :mail";
    public const ADD_QUERY = "INSERT INTO Admin (mailAdmin, nomAdmin, prenomAdmin, dateCreationAdmin, mdpAdmin) VALUES (:mail, :nom, :prenom, :dateCreation, :mdp)";
    public const DELETE_QUERY = "DELETE FROM Admin WHERE mailAdmin = :mail";
    public const UPDATE_QUERY = "UPDATE Admin SET nomAdmin = :nom, prenomAdmin = :prenom, dateCreationAdmin = :dateCreation, mdpAdmin = :mdp WHERE mailAdmin = :mail";
    public const UPDATE_APIKEY_QUERY = "UPDATE Admin SET apiKey = :apiKey, expirationApiKey = :expirationApiKey WHERE mailAdmin = :mail";

    /**
     * Fetch all rows to get all Admin objects.
     */
    public function getAllAdmins(): array
    {
        $admins = [];
        $stmt = DatabaseFactory::getConnection()->prepare(AdminDAO::SELECT_QUERY);
        $stmt->execute();
        
        while ($row = $stmt->fetch()) {
            $admin = new Admin(
                $row["mailAdmin"],
                $row["nomAdmin"],
                $row["prenomAdmin"],
                DateTime::createFromFormat("Y-m-d", $row["dateCreationAdmin"] ?? "1970-01-01"),
                $row["mdpAdmin"],
                $row["apiKey"] ?? "",
                DateTime::createFromFormat("Y-m-d", $row["expirationApiKey"] ?? "1970-01-01")
            );
            $admins[] = $admin;
        }
        return $admins;
    }

    /**
     * Get a specific admin from its email.
     * @param string $mail - The admin email.
     */
    public function getAdmin(string $mail): ?Admin
    {
        $stmt = DatabaseFactory::getConnection()->prepare(AdminDAO::SELECT_ADMIN_QUERY);
        $stmt->execute([
            "mail" => $mail
        ]);
        
        $row = $stmt->fetch();
        if ($row) {
            return new Admin(
                $row["mailAdmin"],
                $row["nomAdmin"],
                $row["prenomAdmin"],
                DateTime::createFromFormat("Y-m-d", $row["dateCreationAdmin"] ?? "1970-01-01"),
                $row["mdpAdmin"],
                $row["apiKey"] ?? "",
                DateTime::createFromFormat("Y-m-d", $row["expirationApiKey"] ?? "1970-01-01")
            );
        }
        return null;
    }

    /**
     * Update a admin row.
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function updateAdmin(Admin $admin): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(AdminDAO::UPDATE_QUERY);
        return $stmt->execute([
            ":mail" => $admin->getEmail(),
            ":nom" => $admin->getNom(),
            ":prenom" => $admin->getPrenom(),
            ":dateCreation" => $admin->getDateCreation()->format("Y-m-d"),
            ":mdp" => $admin->getMdp()
        ]);
    }

    /**
     * Delete a admin row.
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function deleteAdmin(Admin $admin): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(AdminDAO::DELETE_QUERY);
        return $stmt->execute([
            ":mail" => $admin->getEmail()
        ]);
    }

    /**
     * Add a new admin row.
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function addAdmin(Admin $admin): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(AdminDAO::ADD_QUERY);
        $res = $stmt->execute([
            ":mail" => $admin->getEmail(),
            ":nom" => $admin->getNom(),
            ":prenom" => $admin->getPrenom(),
            ":dateCreation" => $admin->getDateCreation()->format("Y-m-d"),
            ":mdp" => $admin->getMdp()
        ]);
        return $res;
    }

    /**
     * Update the admin api key.
     * @return bool - TRUE on success or FALSE on failure.
     */
    public function updateApiKey(Admin $admin): bool
    {
        $stmt = DatabaseFactory::getConnection()->prepare(AdminDAO::UPDATE_APIKEY_QUERY);
        return $stmt->execute([
            ":apiKey" => $admin->getApiKey(),
            ":expirationApiKey" => date("Y-m-d", time() + 86400),
            ":mail" => $admin->getEmail()
        ]);
    }

    /**
     * Get the DAO class name.
     */
    public function getClassName(): string
    {
        return get_class($this);
    }
}
