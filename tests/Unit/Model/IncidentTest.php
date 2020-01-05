<?php
declare(strict_types=1);

namespace Brotkrueml\JobRouterClient\Tests\Unit\Model;

use Brotkrueml\JobRouterClient\Model\Incident;
use PHPUnit\Framework\TestCase;

class IncidentTest extends TestCase
{
    /**
     * @var Incident
     */
    private $subject;

    protected function setUp(): void
    {
        $this->subject = new Incident();
    }

    /**
     * @test
     */
    public function stepIsNullWhenNotSet(): void
    {
        self::assertNull($this->subject->getStep());
    }

    /**
     * @test
     */
    public function initiatorIsAnEmptyStringWhenNotSet(): void
    {
        self::assertSame('', $this->subject->getInitiator());
    }

    /**
     * @test
     */
    public function usernameIsAnEmptyStringWhenNotSet(): void
    {
        self::assertSame('', $this->subject->getUsername());
    }

    /**
     * @test
     */
    public function jobfunctionIsAnEmptyStringWhenNotSet(): void
    {
        self::assertSame('', $this->subject->getJobfunction());
    }

    /**
     * @test
     */
    public function summaryIsAnEmptyStringWhenNotSet(): void
    {
        self::assertSame('', $this->subject->getSummary());
    }

    /**
     * @test
     */
    public function priorityIsNullWhenNotSet(): void
    {
        self::assertNull($this->subject->getPriority());
    }

    /**
     * @test
     */
    public function poolIsNullWhenNotSet(): void
    {
        self::assertNull($this->subject->getPool());
    }

    /**
     * @test
     */
    public function simulationIsNullWhenNotSet(): void
    {
        self::assertNull($this->subject->getSimulation());
    }

    /**
     * @test
     */
    public function stepEscalationDateIsNullWhenNotSet(): void
    {
        self::assertNull($this->subject->getStepEscalationDate());
    }

    /**
     * @test
     */
    public function incidentEscalationDateIsNullWhenNotSet(): void
    {
        self::assertNull($this->subject->getIncidentEscalationDate());
    }

    /**
     * @test
     */
    public function processTableFieldsIsAnEmptyArrayWhenNotSet(): void
    {
        self::assertSame([], $this->subject->getProcessTableFields());
    }

    /**
     * @test
     */
    public function subSubtableIsAnEmptyArrayWhenNotSet(): void
    {
        self::assertSame([], $this->subject->getSubtables());
    }

    /**
     * @test
     */
    public function setAndGetStepAreCorrectImplemented(): void
    {
        $actual = $this->subject->setStep(42);

        self::assertSame($this->subject, $actual);
        self::assertSame(42, $this->subject->getStep());
    }

    /**
     * @test
     */
    public function setAndGetInitiatorAreCorrectImplemented(): void
    {
        $actual = $this->subject->setInitiator('some initiator');

        self::assertSame($this->subject, $actual);
        self::assertSame('some initiator', $this->subject->getInitiator());
    }

    /**
     * @test
     */
    public function setAndGetUsernameAreCorrectImplemented(): void
    {
        $actual = $this->subject->setUsername('some username');

        self::assertSame($this->subject, $actual);
        self::assertSame('some username', $this->subject->getUsername());
    }

    /**
     * @test
     */
    public function setAndGetJobfunctionAreCorrectImplemented(): void
    {
        $actual = $this->subject->setJobfunction('some jobfunction');

        self::assertSame($this->subject, $actual);
        self::assertSame('some jobfunction', $this->subject->getJobfunction());
    }

    /**
     * @test
     */
    public function setAndGetSummaryAreCorrectImplemented(): void
    {
        $actual = $this->subject->setSummary('some summary');

        self::assertSame($this->subject, $actual);
        self::assertSame('some summary', $this->subject->getSummary());
    }

    /**
     * @test
     */
    public function setAndGetPriorityAreCorrectImplemented(): void
    {
        $actual = $this->subject->setPriority(2);

        self::assertSame($this->subject, $actual);
        self::assertSame(2, $this->subject->getPriority());
    }

    /**
     * @test
     */
    public function setPriorityThrowsExceptionWhenTooLow(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1578225130);

        $this->subject->setPriority(0);
    }

    /**
     * @test
     */
    public function setPriorityThrowsExceptionWhenTooHigh(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1578225130);

        $this->subject->setPriority(4);
    }

    /**
     * @test
     */
    public function setAndGetPoolAreCorrectImplemented(): void
    {
        $actual = $this->subject->setPool(123);

        self::assertSame($this->subject, $actual);
        self::assertSame(123, $this->subject->getPool());
    }

    /**
     * @test
     */
    public function setPriorityThrowsExceptionWhenNotAPositiveInteger(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1578228017);

        $this->subject->setPool(0);
    }

    /**
     * @test
     */
    public function setAndGetSimulationAreCorrectImplemented(): void
    {
        $actual = $this->subject->setSimulation(true);

        self::assertSame($this->subject, $actual);
        self::assertTrue($this->subject->getSimulation());

        $this->subject->setSimulation(false);

        self::assertFalse($this->subject->getSimulation());
    }

    /**
     * @test
     */
    public function setAndGetStepEscalationDateAreCorrectImplemented(): void
    {
        $dateTime = new \DateTime('2020-01-05T13:45:17+01:00');

        $actual = $this->subject->setStepEscalationDate($dateTime);

        self::assertSame($this->subject, $actual);
        self::assertSame($dateTime, $this->subject->getStepEscalationDate());
    }

    /**
     * @test
     */
    public function setAndGetIncidentEscalationDateAreCorrectImplemented(): void
    {
        $dateTime = new \DateTime('2020-01-05T13:46:43+01:00');

        $actual = $this->subject->setIncidentEscalationDate($dateTime);

        self::assertSame($this->subject, $actual);
        self::assertSame($dateTime, $this->subject->getIncidentEscalationDate());
    }

    /**
     * @test
     */
    public function setAndGetProcessTableFieldAreCorrectImplementedForAStringValue(): void
    {
        $actual = $this->subject->setProcessTableField('some name', 'some value');

        self::assertSame($this->subject, $actual);
        self::assertSame('some value', $this->subject->getProcessTableField('some name'));
    }

    /**
     * @test
     */
    public function setAndGetProcessTableFieldAreCorrectImplementedForAnArrayValueWithRequiredKeysGiven(): void
    {
        $value = [
            'path' => '/some/path/to/file.pdf',
            'filename' => 'file.pdf',
        ];

        $actual = $this->subject->setProcessTableField('some name', $value);

        self::assertSame($this->subject, $actual);
        self::assertSame($value, $this->subject->getProcessTableField('some name'));
    }

    /**
     * @test
     */
    public function setAndGetProcessTableFieldAreCorrectImplementedForAnArrayValueWithAllAllowedKeysGiven(): void
    {
        $value = [
            'path' => '/some/path/to/file.pdf',
            'filename' => 'file.pdf',
            'contentType' => 'application/pdf',
        ];

        $actual = $this->subject->setProcessTableField('some name', $value);

        self::assertSame($this->subject, $actual);
        self::assertSame($value, $this->subject->getProcessTableField('some name'));
    }

    /**
     * @test
     */
    public function setProcessTableFieldThrowsExceptionOnInvalidArrayKeyValueGiven(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1578226362);

        $this->subject->setProcessTableField(
            'some name',
            ['wrong' => 'not allowed']
        );
    }

    /**
     * @test
     */
    public function setProcessTableFieldThrowsExceptionWhenNoRequiredKeysForArrayValueGiven(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1578226363);

        $this->subject->setProcessTableField(
            'some name',
            []
        );
    }

    /**
     * @test
     */
    public function setProcessTableFieldThrowsExceptionWhenValueTypeIsNotAllowed(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1578225863);

        $this->subject->setProcessTableField('some name', false);
    }

    /**
     * @test
     */
    public function getProcessTableFieldsIsCorrectImplemented(): void
    {
        $this->subject
            ->setProcessTableField('some name', 'some value')
            ->setProcessTableField('some other name', 'some other value')
            ->setProcessTableField('some name', 'some overridden value');

        $expected = [
            'some name' => 'some overridden value',
            'some other name' => 'some other value',
        ];

        self::assertSame($expected, $this->subject->getProcessTableFields());
    }

    /**
     * @test
     */
    public function setAndGetRowsForSubTableIsCorrectImplemented(): void
    {
        $rows = [
            [
                'some subtable 1/1' => 'some value 1/1',
                'some subtable 1/2' => 'some value 1/2',
            ],
            [
                'some subtable 2/1' => 'some value 2/1',
                'some subtable 2/2' => 'some value 2/2',
            ],
        ];

        $actual = $this->subject->setRowsForSubTable('some subtable', $rows);

        self::assertSame($this->subject, $actual);
        self::assertSame($rows, $this->subject->getRowsForSubTable('some subtable'));
    }

    /**
     * @test
     */
    public function addRowToSubTableIsCorrectImplemented(): void
    {
        $row = [
            'some subtable 1' => 'some value 1',
            'some subtable 2' => 'some value 2',
        ];

        $actual = $this->subject->addRowToSubTable('some subtable', $row);

        self::assertSame($this->subject, $actual);
        self::assertSame([$row], $this->subject->getRowsForSubTable('some subtable'));
    }

    /**
     * @test
     */
    public function appendingRowToSubTable(): void
    {
        $rows = [
            [
                'some subtable 1/1' => 'some value 1/1',
                'some subtable 1/2' => 'some value 1/2',
            ],
        ];

        $this->subject->setRowsForSubTable('some subtable', $rows);

        $row = [
            'some subtable 2/1' => 'some value 2/1',
            'some subtable 2/2' => 'some value 2/2',
        ];

        $this->subject->addRowToSubTable('some subtable', $row);

        $expected = \array_merge($rows, [$row]);

        self::assertSame($expected, $this->subject->getRowsForSubTable('some subtable'));
    }
}