<?php

namespace App\Movie;

use App\Entity\Movie;
use App\Repository\MovieRepository;

class MovieProvider
{
    public function __construct(
        // protected or private
        private readonly OmdbApiConsumer $consumer,
        private readonly OmdbMovieTransformer $transformer,
        private readonly MovieRepository $repository
    ) {}
    public function getMovie(string $mode, string $value): Movie
    {
        $data = $this->consumer->fetchMovie($mode, $value);
        if ($entity = $this->repository->findOneBy(['title' => $data['Title']])) {
            return $entity;
        }
        $movie = $this->transformer->transform($data);
        $this->repository->save($movie, true);

        return $movie;
    }
}