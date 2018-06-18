<?php

namespace Bounoable\Quest\Export;

use Bounoable\Quest\GeneratedQuest;

interface FileExporter
{
    /**
     * Export a generated quest to a given path.
     *
     * @throws ExportException
     */
    public function export(GeneratedQuest $quest, string $path): void;

    /**
     * Import a generated quest from a file.
     *
     * @throws ImportException
     */
    public function import(string $path): GeneratedQuest;
}
