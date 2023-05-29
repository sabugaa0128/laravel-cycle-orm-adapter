<?php

declare(strict_types=1);

namespace WayOfDev\Cycle\Testing\Concerns;

use Cycle\Database\DatabaseProviderInterface;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\LogicalNot as ReverseConstraint;
use WayOfDev\Cycle\Testing\Constraints\CountInDatabase;
use WayOfDev\Cycle\Testing\Constraints\HasInDatabase;

/**
 * @method void assertThat($value, Constraint $constraint, string $message = '')
 */
trait InteractsWithDatabase
{
    /**
     * @param string|object $table
     * @param string|null $connection
     *
     * @return $this
     */
    protected function assertDatabaseHas($table, array $data, $connection = null): static
    {
        $this->assertThat(
            $table,
            new HasInDatabase(app(DatabaseProviderInterface::class), $data)
        );

        return $this;
    }

    /**
     * @param string|object $table
     * @param string|null $connection
     *
     * @return $this
     */
    protected function assertDatabaseMissing($table, array $data, $connection = null): static
    {
        $constraint = new ReverseConstraint(
            new HasInDatabase(app(DatabaseProviderInterface::class), $data)
        );

        $this->assertThat($table, $constraint);

        return $this;
    }

    /**
     * @param string|object $table
     * @param string|null $connection
     *
     * @return $this
     */
    protected function assertDatabaseCount($table, int $count, $connection = null): static
    {
        $this->assertThat(
            $table,
            new CountInDatabase(app(DatabaseProviderInterface::class), $count)
        );

        return $this;
    }

    /**
     * @param string|object $table
     * @param string|null $connection
     *
     * @return $this
     */
    protected function assertDatabaseEmpty($table, $connection = null): static
    {
        $this->assertThat(
            $table,
            new CountInDatabase(app(DatabaseProviderInterface::class), 0)
        );

        return $this;
    }
}
