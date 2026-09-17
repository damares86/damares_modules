<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Rate extends Common
{
    public string $table = 'rate';
    public string $table_cat = 'rate_cat';
    public string $pivot_cat = 'file_cat';
    public string $pivot_file = 'file_account_rate';
    public int|string|null $account_id = null;
    public int|string|null $file_id = null;
    public int|string|null $rate = null;
    public int|string|null $percent = null;
    public int|string|null $vote_number = null;
    public ?string $cat_name = null;
    public int|string|null $rate_cat_id = null;

    /**
     * Get category ID for a file.
     *
     * @return int|string|null
     */
    public function showCat(): int|string|null
    {
        if ($this->conn === null) {
            return null;
        }

        $query = "SELECT rate_cat_id FROM {$this->prx}{$this->pivot_cat} WHERE file_id = :file_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':file_id', $this->file_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? ($row['rate_cat_id'] ?? null) : null;
    }

    /**
     * Get category name by ID.
     *
     * @return string|null
     */
    public function showCatName(): ?string
    {
        if ($this->conn === null) {
            return null;
        }

        $query = "SELECT cat_name FROM {$this->prx}{$this->table_cat} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? (string) ($row['cat_name'] ?? '') : null;
    }

    /**
     * Get star rating for a file.
     *
     * @return int|string|null
     */
    public function showStar(): int|string|null
    {
        if ($this->conn === null) {
            return null;
        }

        $query = "SELECT star FROM {$this->prx}{$this->table} WHERE file_id = :file_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':file_id', $this->file_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? ($row['star'] ?? null) : null;
    }

    /**
     * Check if category name exists.
     *
     * @return bool
     */
    public function catExists(): bool
    {
        if ($this->conn === null) {
            return false;
        }

        $query = "SELECT id FROM {$this->prx}{$this->table_cat} WHERE cat_name = :cat_name LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':cat_name', $this->cat_name);
        $stmt->execute();

        return (bool) $stmt->fetchColumn();
    }

    public function deleteAllFileRate(): void
    {
        // Custom bulk delete implementation
    }
}