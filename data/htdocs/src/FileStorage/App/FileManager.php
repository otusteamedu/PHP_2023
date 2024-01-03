<?php

namespace FileStorage\App;

use Common\Application\Helper\Str;
use Doctrine\ORM\EntityManagerInterface;
use FileStorage\Domain\Entity\File;
use Psr\Http\Message\UploadedFileInterface;

readonly class FileManager
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function upload(UploadedFileInterface $file): File
    {
        // Формируем путь для сохранения файла (относительно upload_dir)
        $fname = Str::generateRandom(32);
        $dir = $this->getUploadDir() . '/' . $fname;
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $path = '/' . $fname . '/' . $file->getClientFilename();
        $fullPath = $this->getUploadDir() . $path;

        if (file_exists($fullPath)) {
            throw new \Exception('File already exists');
        }

        $file->moveTo($fullPath);

        // Создаем File
        $f = new File(
            null,
            'ad',
            $file->getClientFilename(),
            $file->getClientMediaType(),
            $file->getSize(),
            $path
        );

        // Сохраняем File в БД
        $this->em->persist($f);
        $this->em->flush();

        return $f;
    }

    public function delete(File $file)
    {
        $fullpath = $this->getUploadDir() . $file->getPath();

        if (file_exists($fullpath)) {
            unlink($fullpath);

            $arFiles = scandir(dirname($fullpath));
            if (count($arFiles) == 2) {
                rmdir(dirname($fullpath));
            }
        }
    }

    private function getUploadDir(): string
    {
        return config()->get('upload_dir');
    }
}
