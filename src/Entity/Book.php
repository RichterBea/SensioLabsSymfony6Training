<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
// will refere only to the one called object - to mark entity as updated
#[ORM\ChangeTrackingPolicy('DEFERRED_EXPLICIT')]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    // to generate a uuid -->
    // #[ORM\GeneratedValue(strategy: 'CUSTOM']
    // [ORM\CustomIdGenerator('doctrine.uuid_generator')]
    #[ORM\Column]
    private ?int $id = null;
// properties which are not defined with default value, it is not accassible in php8!
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 25)]
    private ?string $isbn = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $author = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $releasedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $plot = null;

    // cascade means if the corresponding book is persist/updated or removed it will search and update the comment
    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Comment::class, cascade: ['persist'], fetch: 'EXTRA_LAZY', orphanRemoval: true)]
    private Collection $comment;

    #[ORM\ManyToMany(targetEntity: BookGenre::class, inversedBy: 'books')]
    private Collection $genres;

    public function __construct()
    {
        $this->comment = new ArrayCollection();
        $this->genres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getReleasedAt(): ?\DateTimeImmutable
    {
        return $this->releasedAt;
    }

    public function setReleasedAt(\DateTimeImmutable $releasedAt): self
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    public function getPlot(): ?string
    {
        return $this->plot;
    }

    public function setPlot(?string $plot): self
    {
        $this->plot = $plot;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comment->contains($comment)) {
            $this->comment->add($comment);
            $comment->setBook($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getBook() === $this) {
                $comment->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BookGenre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(BookGenre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
        }

        return $this;
    }

    public function removeGenre(BookGenre $genre): self
    {
        $this->genres->removeElement($genre);

        return $this;
    }
}
