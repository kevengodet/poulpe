<?php

declare(strict_types=1);

namespace Poulpe\File;

/**
 * OO interface to manipulate text files
 *
 * Usage:
 *
 *   $file = new TextFile('/path/to/file');
 *   $file->after('[SECTION 3]')->insert('This will be the line after [SECTION 3]');
 */
final class TextFile
{
    /** @var string[] */
    private array $lines = [];

    private ?int $nextCursor = null;

    private string $filePath;

    private bool $saveOnExit;

    public function __construct(string $filePath = null, bool $saveOnExit = false)
    {
        if (is_null($filePath)) {
            if ($saveOnExit) {
                throw new \LogicException('To save on exit, you need to pass a file path.');
            }

            return;
        }

        $lines = file($filePath);

        if (false === $lines) {
            throw new \RuntimeException("Cannot read file '$filePath'.");
        }

        $this->filePath = $filePath;
        $this->lines = $lines;
        $this->saveOnExit = $saveOnExit;
    }

    /** Set the cursor for the next operation */
    public function after(string $textOrRegex, bool $createIfNotFound = false): self
    {
        $isRegex = (@preg_match($textOrRegex, '') !== false);

        $found = false;
        $n = 0;
        foreach ($this->lines as $n => $line) {
            if ($line === $textOrRegex ||
                ($isRegex && preg_match($textOrRegex, $line))) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            if (!$createIfNotFound) {
                throw new \RuntimeException("Cannot find line '$textOrRegex' in file.");
            }
            $this->lines[] = $textOrRegex;
            $n++;
        }

        $this->nextCursor = $n;

        return $this;
    }

    public function insert(string $line): self
    {
        if (is_null($this->nextCursor)) {
            return $this->append($line);
        }

        array_splice($this->lines, $this->nextCursor, 0, $line);

        return $this;
    }

    /**
     * Does not affect cursor, as it always work at the end of the file
     */
    public function append(string $line): self
    {
        $this->lines[] = $line;

        return $this;
    }

    /**
     * RESET the cursor, as it shift lines' numbers
     */
    public function prepend(string $line): self
    {
        array_unshift($this->lines, $line);
        $this->nextCursor = null;

        return $this;
    }

    /**
     * Safe save
     */
    public function save(): void
    {
        if (!isset($this->filePath)) {
            throw new \LogicException('No file path given to save the file.');
        }

        $this->saveTo($this->filePath);
    }

    public function saveTo(string $path): void
    {
        $tempPath = tempnam(sys_get_temp_dir(), 'TextFile_');

        if (false === file_put_contents(implode("\n", $this->lines), $tempPath)) {
            throw new \RuntimeException("Cannot save file to '$path': temp file '$tempPath' is not writeable.");
        }

        if (false === shell_exec('sudo mv /etc/hosts /etc/hosts.bak')) {
            throw new \RuntimeException("Cannot save file to '$path': cannot rename existing /etc/hosts to /etc/hosts.bak.");
        }

        if (false === shell_exec("sudo mv $tempPath /etc/hosts")) {
            if (false === shell_exec('sudo mv /etc/hosts.bak /etc/hosts')) {
                throw new \RuntimeException("Could not save file to '$path', nor rename /etc/hosts.bak back to /etc/hosts. Please review your hosts file!");
            }

            throw new \RuntimeException("Cannot save file to '$path': cannot rename $tempPath to /etc/hosts.bak.");
        }
    }

    public function __destruct()
    {
        if ($this->saveOnExit) {
            $this->save();
        }
    }
}
