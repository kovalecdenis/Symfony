<?php

namespace App\Service;

use App\Entity\Post;
use Symfony\Component\HttpFoundation\Request;

class ExportPost
{

    //private $path = 'C:\Users\User\PhpstormProjects\Symfony\sources\public\Downloaded_files\\';
    public $path = 'C:\Users\User\PhpstormProjects\Symfony\sources\public\Downloaded_files\\';

    /**
     * @param $type
     * @return string
     */
    public function FileName($type)
    {
        $filename = time() . '.' . $type;
        $filepath = $this->path . $filename;

        return $filepath;
    }

    /**
     * @param Post $post
     * @return string
     */
    public function Csv(Post $post)
    {
        $file_content = $post->getName() . "\n\n" . $post->getDescription() . "\n" . str_repeat("-", 25);
        $filename = $this->FileName('csv');

        file_put_contents($filename, $file_content);

        return $filename;
    }

    /**
     * @param Post $post
     * @return string
     */
    public function HTML(Post $post)
    {
        $file_content = '<html><body><h1>'.$post->getName().'</h1><p>'.$post->getDescription().'</p></body>';
        $filename = $this->FileName('html');

        file_put_contents($filename, $file_content);

        return $filename;
    }
}


