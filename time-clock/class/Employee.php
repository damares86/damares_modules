<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    Estensione Timbrature - Dipendenti    #
#                                          #
############################################

class Employee extends Common
{
    public string $table = 'employee';
    public ?string $name = null;
    public ?string $badge = null;
    public float|string|null $h_mon = 8.00;
    public float|string|null $h_tue = 8.00;
    public float|string|null $h_wed = 8.00;
    public float|string|null $h_thu = 8.00;
    public float|string|null $h_fri = 8.00;
    public int|string|null $active = 1;
    public ?string $notes = null;

    /**
     * Get array of managed fields.
     *
     * @return array<int, string>
     */
    public function fields(): array
    {
        return ['name', 'badge', 'h_mon', 'h_tue', 'h_wed', 'h_thu', 'h_fri', 'active', 'notes'];
    }

    /**
     * Get all employees sorted by name.
     *
     * @param bool $onlyActive
     * @return array<int, array<string, mixed>>
     */
    public function allEmployees(bool $onlyActive = false): array
    {
        if ($this->conn === null) {
            return [];
        }

        $sql = "SELECT * FROM {$this->prx}{$this->table}";
        if ($onlyActive) {
            $sql .= ' WHERE active = 1';
        }
        $sql .= ' ORDER BY name ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (array) $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get employee by ID.
     *
     * @param int|string $id
     * @return array<string, mixed>|false
     */
    public function getById(int|string $id): array|false
    {
        if ($this->conn === null) {
            return false;
        }

        $stmt = $this->conn->prepare("SELECT * FROM {$this->prx}{$this->table} WHERE id = :id LIMIT 1");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return is_array($res) ? $res : false;
    }

    /**
     * Find employee by badge or name.
     *
     * @param ?string $badge
     * @param string $name
     * @return array<string, mixed>|false
     */
    public function findByBadgeOrName(?string $badge, string $name): array|false
    {
        if ($this->conn === null) {
            return false;
        }

        if ($badge !== null && $badge !== '') {
            $stmt = $this->conn->prepare("SELECT * FROM {$this->prx}{$this->table} WHERE badge = :badge LIMIT 1");
            $stmt->bindValue(':badge', $badge);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (is_array($row)) {
                return $row;
            }
        }

        $clean = preg_replace('/\s+/', ' ', trim($name));
        $stmt = $this->conn->prepare("SELECT * FROM {$this->prx}{$this->table} WHERE LOWER(TRIM(name)) = LOWER(:name) LIMIT 1");
        $stmt->bindValue(':name', $clean);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return is_array($row) ? $row : false;
    }

    /**
     * Quickly create employee record.
     *
     * @param string $name
     * @param ?string $badge
     * @return int
     */
    public function quickCreate(string $name, ?string $badge): int
    {
        if ($this->conn === null) {
            return 0;
        }

        $clean = preg_replace('/\s+/', ' ', trim($name));
        $stmt = $this->conn->prepare("INSERT INTO {$this->prx}{$this->table} (`name`, `badge`, `h_mon`, `h_tue`, `h_wed`, `h_thu`, `h_fri`, `active`) VALUES (:name, :badge, 8, 8, 8, 8, 8, 1)");
        $stmt->bindValue(':name', $clean);
        $stmt->bindValue(':badge', $badge);
        $stmt->execute();

        return (int) $this->conn->lastInsertId();
    }

    /**
     * Contract hours for ISO day of the week.
     *
     * @param array<string, mixed> $row
     * @param int $isoDay
     * @return float
     */
    public static function contractHours(array $row, int $isoDay): float
    {
        $map = [1 => 'h_mon', 2 => 'h_tue', 3 => 'h_wed', 4 => 'h_thu', 5 => 'h_fri'];
        if (!isset($map[$isoDay]) || !isset($row[$map[$isoDay]])) {
            return 0.0;
        }
        return (float) $row[$map[$isoDay]];
    }

    /**
     * Total contract hours per week.
     *
     * @param array<string, mixed> $row
     * @return float
     */
    public static function weekTotal(array $row): float
    {
        return (float) ($row['h_mon'] ?? 0) + (float) ($row['h_tue'] ?? 0) + (float) ($row['h_wed'] ?? 0)
            + (float) ($row['h_thu'] ?? 0) + (float) ($row['h_fri'] ?? 0);
    }
}
