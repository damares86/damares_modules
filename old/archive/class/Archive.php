<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Archive extends Common
{
    public string $table = 'archive_files';
    public int|string|null $archive_year_id = null;
    public ?int $year = null;
    public ?string $file_name = null;
    public ?string $title = null;
    public int|string|null $year_id = null;
    public ?int $month = null;
    public ?string $filename_orig = null;
    public ?string $label = null;
    public ?string $inputFileName = null;
    public ?string $path = null;
    public ?string $origin = null;
    public ?string $operation = null;

    /**
     * Upload archive file with validation and database registration.
     *
     * @return bool
     */
    public function uploadFile(): bool
    {
        if (empty($this->file_name) || empty($this->path) || empty($this->inputFileName)) {
            return false;
        }

        $targetDirectory = rtrim($this->path, '/\\') . DIRECTORY_SEPARATOR;
        $targetFile = $targetDirectory . basename($this->file_name);
        $fileType = strtolower((string) pathinfo($targetFile, PATHINFO_EXTENSION));

        $allowedFileTypes = ['png', 'jpg', 'jpeg', 'gif', 'pdf', 'doc', 'docx', 'zip', 'mp3'];
        if (!in_array($fileType, $allowedFileTypes, true)) {
            $origin = !empty($this->origin) ? $this->origin : 'allArchive';
            header("Location: ../index.php?p={$origin}&err=formatErr");
            exit;
        }

        if (file_exists($targetFile)) {
            @rename($targetFile, $targetFile . '_old');
        }

        if (!is_dir($targetDirectory)) {
            @mkdir($targetDirectory, 0755, true);
        }

        if (is_uploaded_file($this->inputFileName) && move_uploaded_file($this->inputFileName, $targetFile)) {
            @chmod($targetFile, 0644);

            if ($this->operation === 'add') {
                $query = "INSERT INTO {$this->prx}{$this->table} (file_name, title, archive_year_id, month) VALUES (:file_name, :title, :archive_year_id, :month)";
            } elseif ($this->operation === 'edit') {
                $query = "UPDATE {$this->prx}{$this->table} SET file_name = :file_name, title = :title, archive_year_id = :archive_year_id, month = :month WHERE id = :id";
            } else {
                return true;
            }

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':file_name', $this->file_name);
            $stmt->bindValue(':title', $this->title);
            $stmt->bindValue(':archive_year_id', $this->archive_year_id);
            $stmt->bindValue(':month', $this->month);
            if ($this->operation === 'edit') {
                $stmt->bindValue(':id', $this->id);
            }

            return $stmt->execute();
        }

        return false;
    }
}
