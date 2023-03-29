<?php

namespace App\Movie;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Component\Console\Style\SymfonyStyle;

class MovieProvider
{
    protected ?SymfonyStyle $io = null;
    public function __construct(
        // protected or private
        private readonly OmdbApiConsumer $consumer,
        private readonly OmdbMovieTransformer $transformer,
        private readonly MovieRepository $repository
    ) {}
    public function getMovie(string $mode, string $value): Movie
    {
        $this->io?->text('Checking movie title with OMDb...');
        $data = $this->consumer->fetchMovie($mode, $value);
        if ($entity = $this->repository->findOneBy(['title' => $data['Title']])) {
            return $entity;
        }
        // if not, transform result from API
        $movie = $this->transformer->transform($data);
        // save result to DB
        $this->io?->text('Saving movie to database...');
        $this->repository->save($movie, true);

        // return result
        return $movie;
    }

    public function setIo(SymfonyStyle $io): void
    {
        $this->io = $io;
    }
}