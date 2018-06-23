<?php

namespace Bounoable\Quest\Export;

use Bounoable\Quest\Quest;

interface FileExporter
{
    /**
     * Export a quest to a given path.
     *
     * @throws ExportException
     */
    public function export(Quest $quest, string $path): void;

    /**
     * Import a quest from a file.
     *
     * @throws ImportException
     */
    public function import(string $path): Quest;
}
