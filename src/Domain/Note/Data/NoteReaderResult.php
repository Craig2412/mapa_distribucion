<?php

namespace App\Domain\Note\Data;

final class NoteReaderResult
{
    public ?int $id = null;
    public ?string $note = null;
    public ?int $id_user = null;
    public ?string $nombre = null;
    public ?int $id_task = null;
    public ?string $title = null;
    public ?int $id_file = null;
    public ?string $file_name = null;
    public ?string $created = null;
    public ?string $updated = null;
}