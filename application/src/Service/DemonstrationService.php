<?php

declare(strict_types=1);

namespace Gesparo\HW\Service;

use Gesparo\HW\AppException;
use Gesparo\HW\Entity\Film;
use Gesparo\HW\Mapper\FilmMapper;
use Gesparo\HW\Mapper\ScreeningMapper;
use Gesparo\HW\OutputHelper;

class DemonstrationService
{
    private OutputHelper $outputHelper;
    private FilmMapper $filmMapper;
    private ScreeningMapper $screeningMapper;

    public function __construct(FilmMapper $filmMapper, ScreeningMapper $screeningMapper, OutputHelper $outputHelper)
    {
        $this->outputHelper = $outputHelper;
        $this->filmMapper = $filmMapper;
        $this->screeningMapper = $screeningMapper;
    }

    /**
     * @throws AppException
     * @throws \JsonException
     */
    public function run(): void
    {
        $this->outputHelper->info('Start demonstration');

        $films = $this->insertFilms();
        $this->outputHelper->info('Inserted ' . count($films) . ' films');

        $screenings = $this->insertScreenings($films[0]);

        $this->outputHelper->info('Inserted ' . count($screenings) . ' screenings for film ' . $films[0]->getName());

        $this->outputHelper->info('Lazy load demonstration');

        foreach ($films[0]->getScreenings() as $screening) {
            $this->outputHelper->info('Screening: ' . $screening->getDate() . ' ' . $screening->getTime());
        }

        $this->outputHelper->info('End demonstration');
    }

    /**
     * @throws AppException
     * @throws \JsonException
     * @return Film[]
     */
    private function insertFilms(): array
    {
        $now = $this->getNow();
        $films = [];
        $films[] = $this->filmMapper->insert([
            'name' => 'Shawshank redemption',
            'duration' => 150,
            'description' => 'The Shawshank Redemption is a 1994 American prison drama ...',
            'actors' => 'Tim Robbins, Morgan Freeman, Bob Gunton',
            'country' => 'USA',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $films[] = $this->filmMapper->insert([
            'name' => 'The Godfather',
            'duration' => 144,
            'description' => 'The Godfather is a 1972 American crime film directed by Francis Ford ...',
            'actors' => 'Marlon Brando, Al Pacino, James Caan',
            'country' => 'USA',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $films[] = $this->filmMapper->insert([
            'name' => 'The Dark Knight',
            'duration' => 99,
            'description' => 'The Dark Knight is a 2008 superhero film directed, co-produced ... ',
            'actors' => 'Christian Bale, Heath Ledger, Aaron Eckhart',
            'country' => 'USA',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $films;
    }

    private function getNow(): string
    {
        return date('Y-m-d H:i:s');
    }

    private function insertScreenings(Film $film): array
    {
        $now = $this->getNow();
        $screenings = [];
        $screenings[] = $this->screeningMapper->insert([
            'film_id' => $film->getId(),
            'date' => '2021-01-01',
            'time' => '10:00:00',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $screenings[] = $this->screeningMapper->insert([
            'film_id' => $film->getId(),
            'date' => '2021-01-01',
            'time' => '12:00:00',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $screenings[] = $this->screeningMapper->insert([
            'film_id' => $film->getId(),
            'date' => '2021-01-01',
            'time' => '14:00:00',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $screenings;
    }
}
