<?php
namespace Database;
use PDO;
use PDOException;

class Database {
    private string $host;
    private string $dbName;
    private string $username;
    private string $password;
    private ?PDO $conn = null;

    public function __construct(
        string $host = 'localhost',
        string $dbName = 'blog',
        string $username = 'root',
        string $password = ''
    ) {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect(): ?PDO {
        if ($this->conn !== null) {
            return $this->conn;
        }

        try {
            $dsn = "mysql:host=$this->host;dbname=$this->dbName;charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
        }

        return $this->conn;
    }

    private function ensureConnection(): void {
        if ($this->conn === null) {
            $this->connect();
        }
    }

    public function select(string $sql, ?array $values = null): ?array {
        $this->ensureConnection();

        try {
            if ($values === null) {
                $stmt = $this->conn->query($sql);
            } else {
                $stmt = $this->conn->prepare($sql);
                $stmt->execute($values);
            }
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Select query failed: " . $e->getMessage());
            return null;
        }
    }

    public function insert(string $tableName, array $fields, array $values): bool {
        $this->ensureConnection();

        if (count($fields) !== count($values)) {
            error_log("Insert failed: fields and values count mismatch.");
            return false;
        }

        try {
            $placeholders = array_map(static fn($field) => ':' . $field, $fields);
            $sql = "INSERT INTO $tableName (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholders) . ")";
            $stmt = $this->conn->prepare($sql);
            $data = [];
            foreach ($fields as $index => $field) {
                $data[':' . $field] = $values[$index];
            }

            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Insert query failed: " . $e->getMessage());
            return false;
        }
    }


    public function execute(string $sql, array $values = []): bool {
        $this->ensureConnection();

        try {
            return $this->conn->prepare($sql)->execute($values);
        } catch (PDOException $e) {
            error_log("Execute query failed: " . $e->getMessage());
            return false;
        }
    }

    public function createTable(string $sql): bool {
        $this->ensureConnection();

        try {
            $this->conn->exec($sql);
            return true;
        } catch (PDOException $e) {
            error_log("Table creation failed: " . $e->getMessage());
            return false;
        }
    }

    public function disconnect(): void {
        $this->conn = null;
    }
}
