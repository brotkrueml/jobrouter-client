<?php
declare(strict_types=1);

namespace Brotkrueml\JobRouterClient\Tests\Unit\Resource;

use Brotkrueml\JobRouterClient\Resource\FileInterface;
use Brotkrueml\JobRouterClient\Resource\FileStorage;
use PHPUnit\Framework\TestCase;

class FileStorageTest extends TestCase
{
    /** @var FileStorage */
    private $subject;

    protected function setUp(): void
    {
        $this->subject = new FileStorage();
    }

    /**
     * @test
     */
    public function countMethodReturns0WhenNoFilesAreAttached(): void
    {
        self::assertSame(0, $this->subject->count());
    }

    /**
     * @test
     */
    public function fileStorageImplementsCountableInterface(): void
    {
        self::assertInstanceOf(\Countable::class, $this->subject);
        self::assertSame(0, \count($this->subject));
    }

    /**
     * @test
     */
    public function attachAddsFilesToFileStorage(): void
    {
        $fileStub1 = $this->createStub(FileInterface::class);
        $this->subject->attach($fileStub1);

        self::assertTrue($this->subject->contains($fileStub1));
        self::assertCount(1, $this->subject);

        $fileStub2 = $this->createStub(FileInterface::class);
        $this->subject->attach($fileStub2);

        self::assertTrue($this->subject->contains($fileStub2));
        self::assertCount(2, $this->subject);
    }

    /**
     * @test
     */
    public function attachAddsTheSameFileOnlyOnceToFileStorage(): void
    {
        $fileStub = $this->createStub(FileInterface::class);
        $this->subject->attach($fileStub);

        self::assertCount(1, $this->subject);

        $this->subject->attach($fileStub);

        self::assertCount(1, $this->subject);
    }

    /**
     * @test
     */
    public function detachRemovesAFileFromFileStorage(): void
    {
        $fileStub = $this->createStub(FileInterface::class);
        $this->subject->attach($fileStub);

        $this->subject->detach($fileStub);

        self::assertFalse($this->subject->contains($fileStub));
        self::assertCount(0, $this->subject);
    }

    /**
     * @test
     */
    public function currentReturnsFalseWhenFileStorageIsEmpty(): void
    {
        self::assertFalse($this->subject->current());
    }

    /**
     * @test
     */
    public function validReturnsFalseWhenFileStorageIsEmpty(): void
    {
        self::assertFalse($this->subject->valid());
    }

    /**
     * @test
     */
    public function fileStorageImplementsIteratorInterface(): void
    {
        self::assertInstanceOf(\Iterator::class, $this->subject);

        $fileStub1 = $this->createStub(FileInterface::class);
        $fileStub2 = $this->createStub(FileInterface::class);
        $fileStub3 = $this->createStub(FileInterface::class);
        $this->subject->attach($fileStub1);
        $this->subject->attach($fileStub2);
        $this->subject->attach($fileStub3);

        self::assertTrue($this->subject->valid());
        self::assertSame($fileStub1, $this->subject->current());
        self::assertSame(\spl_object_hash($fileStub1), $this->subject->key());

        $this->subject->next();

        self::assertTrue($this->subject->valid());
        self::assertSame($fileStub2, $this->subject->current());
        self::assertSame(\spl_object_hash($fileStub2), $this->subject->key());

        $this->subject->next();

        self::assertTrue($this->subject->valid());
        self::assertSame($fileStub3, $this->subject->current());
        self::assertSame(\spl_object_hash($fileStub3), $this->subject->key());

        $this->subject->next();

        self::assertFalse($this->subject->valid());
        self::assertFalse($this->subject->current());

        $this->subject->rewind();

        self::assertTrue($this->subject->valid());
        self::assertSame($fileStub1, $this->subject->current());
    }
}

