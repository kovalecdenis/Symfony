<?php

namespace App\Service;

use App\Entity\Post;
use Symfony\Component\HttpFoundation\Request;

class ExportPost
{
    /**
     * @todo write in services.yaml
     * @var string
     */
    private $path = 'C:\Users\User\PhpstormProjects\Symfony\sources\public\Downloaded_files\\';

    /**
     * @param  string $type
     * @return string
     */
    public function FileName($type)
    {
        $filename = time() . '.' . $type;
        return $filename;
    }

    /**
     * @param  string $filename
     * @return string
     */
    public function GetPath($filename)
    {
        $filepath = $this->path . $filename;

        return $filepath;
    }

    /**
     * @param Post $post
     * @return string
     */
    public function Csv(Post $post)
    {
        $file_content = $post->getName() . "\n\n" . $post->getDescription() . "\n" . str_repeat('-', 25);
        $filename = $this->FileName('csv');
        $filepath = $this->GetPath($filename);

        file_put_contents($filepath, $file_content);
         return $filename;
    }

    /**
     * @param Post $post
     * @return string
     */
    public function Html(Post $post)
    {
        $file_content = '<html><body><h1>'.$post->getName().'</h1><p>'.$post->getDescription().'</p></body>';
        $filename = $this->FileName('html');
        $filepath = $this->GetPath($filename);

        file_put_contents($filepath, $file_content);
        return $filename;
    }
}
