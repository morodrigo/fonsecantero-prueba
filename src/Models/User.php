<?php

class User
{
    private $id;
    private $username;
    private const TABLE = 'users';
    // Hash de la contraseña
    private function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    // Guardar el usuario en la base de datos
    public function save($username, $password, $createdAt)
    {
        try {
            $db = Database::getInstance();

            $stmt = $db->prepare("SELECT COUNT(*) FROM ".self::TABLE." WHERE username = ?");
            $stmt->execute([$username]);
            $userExists = $stmt->fetchColumn();

            if ($userExists) {
                return ['success' => false, 'message' => 'El nombre de usuario ya existe.'];
            }

            $stmt = $db->prepare("INSERT INTO " . self::TABLE . " (username, password, created_at) VALUES (?, ?, ?)");

            if ($stmt->execute([$username,
                self::hashPassword($password),
                $createdAt
            ])) {
                return ['success' => true];
            } else {
                return ['success' => false, 'message' => 'Error al guardar el usuario.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()];
        }
    }

    

    // Buscar usuario por nombre de usuario
    public static function findByUsername($username)
    {
        try {
            $db = Database::getInstance();
            $stmt = $db->prepare("SELECT * FROM " . self::TABLE . " WHERE username = :username  LIMIT 1");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetchObject(__CLASS__);
            return $user ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    // Validar  usuario
    public static function authenticate($username, $password)
    {
        $user = self::findByUsername($username);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

  

   

}
