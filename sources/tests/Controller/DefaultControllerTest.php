<?php

namespace App\Tests\Controller;


use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testDefaultController(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Title of a longer featured blog post');

        $link = $crawler->selectLink('About');
        $this->assertCount(1, $link);
        $crawler = $client->request('GET', '/about');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'About');

        $link = $crawler->selectLink('Feedback');
        $this->assertCount(1, $link);
        $crawler = $client->request('GET', '/feedback');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Feedback');
    }

    public function testPostEntity(): void
    {
        $post = new Post();

        $name = 'Alex';
        $post->setName($name);
        $this->assertTrue($post->getName() == $name);

        $desc = 'Test description';
        $post->setDescription($desc);
        $this->assertTrue($post->getDescription() == $desc);
    }

    /**
     * @TODO: получить последний id
     */
    public function testPostController(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Title of a longer featured blog post');

        $link = $crawler->selectLink('Create Post');
        $this->assertCount(1, $link);

        $crawler = $client->request('GET', '/post/create');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('strong', 'Create Post');

        $form = $crawler->selectButton('Submit')->form();

        //$form = $button->form();
         //$name = $this->getName();

        $form['post_form[Name]'] = 'Test post-' . rand(0, 100);
        $form['post_form[Description]'] = 'Test description';
        $client->submit($form);

        // $this->assertResponseRedirects(...) // postid

    }
}
