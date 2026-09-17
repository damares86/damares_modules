<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Relation extends Common
{
    public string $table = 'relations';
    public int|string|null $id = null;
    public ?string $name = null;
    public ?string $avatar = 'default.png';
    public ?string $description = null;
    public ?string $details = null;
    public ?string $details_opt = null;
    public ?string $relations_name = null;
    public ?string $date = null;
    public ?string $start_time = null;
    public ?string $end_time = null;
    public int|string|null $location = null;
    public ?string $announcer_id = null;
    public ?string $speakers_name = null;
    public ?string $speakers_id = null;
    public int|string|null $speaker_id = null;
    public int|string|null $relation_id = null;
    public int|string|null $speaker_doc_id = null;
    public ?string $speakers_doc_name = null;
    public ?string $inputFileName = null;
    public ?string $path = null;
    public ?string $origin = null;
    public ?string $label = null;
    public int|string|null $active = 0;

    /**
     * Upload speaker document.
     *
     * @return bool
     */
    public function uploadFile(): bool
    {
        if (empty($this->speakers_doc_name) || empty($this->path) || empty($this->inputFileName)) {
            return false;
        }

        $targetDirectory = rtrim($this->path, '/\\') . DIRECTORY_SEPARATOR;
        $targetFile = $targetDirectory . basename($this->speakers_doc_name);
        $fileType = strtolower((string) pathinfo($targetFile, PATHINFO_EXTENSION));

        if ($fileType !== 'pdf') {
            $origin = !empty($this->origin) ? $this->origin : 'allSpeakers';
            header("Location: ../index.php?p={$origin}&idToMod={$this->id}&err=formatErr");
            exit;
        }

        if (!is_dir($targetDirectory)) {
            @mkdir($targetDirectory, 0755, true);
        }

        if (is_uploaded_file($this->inputFileName) && move_uploaded_file($this->inputFileName, $targetFile)) {
            @chmod($targetFile, 0644);

            $query = "INSERT INTO {$this->prx}{$this->table} (speakers_doc_name, label, speaker_id) VALUES (:speakers_doc_name, :label, :speaker_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':speakers_doc_name', $this->speakers_doc_name);
            $stmt->bindValue(':label', $this->label);
            $stmt->bindValue(':speaker_id', $this->speaker_id);

            return $stmt->execute();
        }

        return false;
    }
}