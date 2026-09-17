<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    Estensione Timbrature - Timbrature    #
#                                          #
############################################

class Punch extends Common
{
    public string $table = 'punch';
    public int|string|null $employee_id = null;
    public ?string $punch_date = null;
    public ?string $punch_time = null;
    public ?string $source = null;

    /**
     * Add punch record idempotently.
     *
     * @param int|string $employeeId
     * @param string $date
     * @param string $time
     * @param ?string $source
     * @return bool
     */
    public function add(int|string $employeeId, string $date, string $time, ?string $source = null): bool
    {
        if ($this->conn === null) {
            return false;
        }

        $sql = "INSERT INTO {$this->prx}{$this->table} (`employee_id`, `punch_date`, `punch_time`, `source`)
                VALUES (:employee_id, :punch_date, :punch_time, :source)
                ON DUPLICATE KEY UPDATE `source` = VALUES(`source`)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':employee_id', $employeeId);
        $stmt->bindValue(':punch_date', $date);
        $stmt->bindValue(':punch_time', $time);
        $stmt->bindValue(':source', $source);

        return $stmt->execute();
    }

    /**
     * Group punches for a month by employee.
     *
     * @param int $year
     * @param int $month
     * @param int|string|null $employeeId
     * @return array<int, array<string, array<int, string>>>
     */
    public function monthGrouped(int $year, int $month, int|string|null $employeeId = null): array
    {
        if ($this->conn === null) {
            return [];
        }

        $from = sprintf('%04d-%02d-01', $year, $month);
        $to   = (string) date('Y-m-t', (int) strtotime($from));

        $sql = "SELECT employee_id, punch_date, punch_time FROM {$this->prx}{$this->table}
                WHERE punch_date BETWEEN :from AND :to";
        if ($employeeId) {
            $sql .= ' AND employee_id = :eid';
        }
        $sql .= ' ORDER BY employee_id, punch_date, punch_time';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':from', $from);
        $stmt->bindValue(':to', $to);
        if ($employeeId) {
            $stmt->bindValue(':eid', $employeeId);
        }
        $stmt->execute();

        $out = [];
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $eId = (int) $r['employee_id'];
            $pDate = (string) $r['punch_date'];
            $pTime = (string) $r['punch_time'];
            $out[$eId][$pDate][] = $pTime;
        }
        return $out;
    }

    /**
     * Available months with records.
     *
     * @return array<int, array<string, mixed>>
     */
    public function availableMonths(): array
    {
        if ($this->conn === null) {
            return [];
        }

        $sql = "SELECT DATE_FORMAT(punch_date, '%Y-%m') AS ym, COUNT(*) AS tot
                FROM {$this->prx}{$this->table} GROUP BY ym ORDER BY ym DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (array) $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Delete punch records for a given month.
     *
     * @param int $year
     * @param int $month
     * @return bool
     */
    public function deleteMonth(int $year, int $month): bool
    {
        if ($this->conn === null) {
            return false;
        }

        $from = sprintf('%04d-%02d-01', $year, $month);
        $to   = (string) date('Y-m-t', (int) strtotime($from));
        $stmt = $this->conn->prepare("DELETE FROM {$this->prx}{$this->table} WHERE punch_date BETWEEN :from AND :to");
        $stmt->bindValue(':from', $from);
        $stmt->bindValue(':to', $to);
        return $stmt->execute();
    }

    /**
     * Build day punch pairs and calculate total hours.
     *
     * @param array<int, string> $times
     * @return array{pairs: array<int, array{0: string, 1: ?string}>, hours: float, odd: bool}
     */
    public static function buildDay(array $times): array
    {
        sort($times);
        $pairs = [];
        $seconds = 0;
        $odd = false;
        $count = count($times);

        for ($i = 0; $i < $count; $i += 2) {
            $in = $times[$i];
            $out = $times[$i + 1] ?? null;
            if ($out === null) {
                $odd = true;
                $pairs[] = [$in, null];
                break;
            }
            $pairs[] = [$in, $out];
            $seconds += max(0, (int) strtotime($out) - (int) strtotime($in));
        }

        return [
            'pairs' => $pairs,
            'hours' => round($seconds / 3600, 2),
            'odd'   => $odd,
        ];
    }

    /**
     * Format decimal hours as HH:MM.
     *
     * @param float $decimalHours
     * @return string
     */
    public static function hhmm(float $decimalHours): string
    {
        $sign = $decimalHours < 0 ? '-' : '';
        $absHours = abs($decimalHours);
        $h = (int) floor($absHours);
        $m = (int) round(($absHours - $h) * 60);
        if ($m === 60) {
            $h++;
            $m = 0;
        }
        return sprintf('%s%d:%02d', $sign, $h, $m);
    }
}
