<?php
// src/Models/Task.php

class Task
{
    private $id;
    private $title;
    private $description;
    private $status;
    private $userId;
    private $createdAt;
    private $updatedAt;
    private const TABLE = 'tasks';

    // Consructor de la clase Task, inicializa las propiedades de la tarea.
    public function __construct($title, $description, $status,$userId, $id = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->userId = $userId;
        $this->createdAt = date('Y-m-d H:i:s');
        $this->updatedAt = date('Y-m-d H:i:s');
    }

    // Guarda o actualiza una tarea en la base de datos.
    public function save()
    {
        $db = Database::getInstance();

        // Validar campos
        if (empty($this->title) || empty($this->description)) {
            return ['success' => false, 'message' => 'El título y la descripción no pueden estar vacíos.'];
        }

        $validStatuses = ['pendiente', 'en progreso', 'completada'];
        if (!in_array($this->status, $validStatuses)) {
            return ['success' => false, 'message' => 'Estado inválido.'];
        }

        try {
            if (isset($this->id)) {
                // Actualizar tarea existente
                $stmt = $db->prepare("UPDATE ".self::TABLE." SET title = ?, description = ?, status = ?, updated_at = ? WHERE id = ?");
                $result = $stmt->execute([$this->title, $this->description, $this->status, $this->updatedAt, $this->id]);
            } else {
                // Crear nueva tarea
                $stmt = $db->prepare("INSERT INTO " . self::TABLE . " (title, description, status, user_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
                $result = $stmt->execute([$this->title, $this->description, $this->status, $this->userId, $this->createdAt, $this->updatedAt]);
            }

            if ($result) {
                return ['success' => true];
            } else {
                return ['success' => false, 'message' => 'No se pudo guardar la tarea.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    // Elimina una tarea específica de la base de datos.
    public static function delete($id)
    {
        $db = Database::getInstance();
        try {
            $stmt = $db->prepare("DELETE FROM " . self::TABLE . " WHERE id = ?");
            $result = $stmt->execute([$id]);

            if ($result) {
                return ['success' => true, 'message' => 'La tarea ha sido eliminada exitosamente.'];
            } else {
                return ['success' => false, 'message' => 'No se pudo eliminar la tarea.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    // Obtiene todas las tareas de un usuario específico.
    public static function findAll($userId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM " . self::TABLE . " WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtiene una tarea por su ID desde la base de datos.
    public static function fetchTaskById($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM " . self::TABLE . " WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
