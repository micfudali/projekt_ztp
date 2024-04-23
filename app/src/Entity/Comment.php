<?php

/**
 * Comment entity.
 */

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class comment.
 */
#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ORM\Table(name: 'comments')]
class Comment
{
    /**
     * Primary key.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * Email.
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    /**
     * Nick.
     */
    #[ORM\Column(type: 'string', length: 64)]
    private $nick;

    /**
     * Contents.
     */
    #[ORM\Column(type: 'text')]
    private $contents;

    /**
     * Post Id.
     */
    #[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private $post;

    /**
     * Getter for id.
     *
     * @return int|null id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Setter for email.
     *
     * @param string $email Email
     *
     * @return $this Returns this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Getter for email.
     *
     * @return string|null Email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Getter for nick.
     *
     * @return string|null Nick
     */
    public function getNick(): ?string
    {
        return $this->nick;
    }

    /**
     * Setter for nick.
     *
     * @param string $nick Nick
     *
     * @return $this Returns this
     */
    public function setNick(string $nick): self
    {
        $this->nick = $nick;

        return $this;
    }

    /**
     * Getter for contents.
     *
     * @return string|null Contents
     */
    public function getContents(): ?string
    {
        return $this->contents;
    }

    /**
     * Setter for contents.
     *
     * @param string $contents Contents
     *
     * @return $this Returns this
     */
    public function setContents(string $contents): self
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * Getter for post.
     *
     * @return Post|null Post
     */
    public function getPost(): ?Post
    {
        return $this->post;
    }

    /**
     * Setter for post.
     *
     * @param Post|null $post Post
     *
     * @return $this Returns this
     */
    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }
}
