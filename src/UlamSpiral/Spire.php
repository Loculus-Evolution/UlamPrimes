<?php

declare(strict_types=1);

namespace Loculus\UlamSpiral;

class Spire
{
    private array $matrix = [];

    private int $stepX = 1;
    private int $stepY = 1;
    private int $directionX = 1;
    private int $directionY = 1;

    private int $start;
    private int $end;

    private Point $current;
    private Point $last;

    private int $number;

    /**
     * @pattern constructor
     *
     * @param int $start
     * @param int $end
     */
    public function __construct(int $start, int $end)
    {
        $this->start = $start;
        $this->end = $end;

        $this->init();
    }

    private function init(): void
    {
        $radius = (sqrt($this->end) / 2);

        for ($x=-$radius; $x<$radius; $x++) {
            for ($y=-$radius; $y<$radius; $y++) {
                $this->matrix[$x][$y] = 0;
            }
        }

        $this->current = new Point(0, 0);
        $this->last = new Point(0, 0);
    }

    public function calculate(bool $moveFirst = false): void
    {
        $this->number = $this->start;
        $this->matrix[$this->current->getX()][$this->current->getY()] = $this->number;

        try {
            do {
                $this->move();
            } while (true);
        } catch (\Exception $e) {
            // end
        };
    }

    private function move(): void
    {
        $this->moveX();
        $this->moveY();
    }

    private function moveY(): void
    {
        $x = $this->current->getX();
        $y = $this->current->getY();

        for ($j=1; $j<=$this->stepY; $j++) {
            $y += $this->directionY;

            $this->current = new Point($x, $y);
            $this->matrix[$x][$y] = ++$this->number;

            $this->validateNumber();
        }

        switch ($this->directionY) {
            case -1:
                $this->directionY = 1;
                break;
            case 1:
                $this->directionY = -1;
                break;
        }

        $this->stepY++;
    }

    private function moveX(): void
    {
        $x = $this->current->getX();
        $y = $this->current->getY();

        for ($i=1; $i<=$this->stepX; $i++) {
            $x += $this->directionX;

            $this->current = new Point($x, $y);
            $this->matrix[$x][$y] = ++$this->number;

            $this->validateNumber();
        }

        switch ($this->directionX) {
            case -1:
                $this->directionX = 1;
                break;
            case 1:
                $this->directionX = -1;
                break;
        }

        $this->stepX++;
    }

    /**
     * @throws \Exception
     */
    private function validateNumber(): void
    {
        if ($this->number === $this->end) {
            throw new \Exception(sprintf('Reached %d', $this->end));
        }
    }

    /**
     * @return array
     */
    public function getMatrix()
    {
        return $this->matrix;
    }
}
