<?php
declare(strict_types=1);

namespace Brotkrueml\JobRouterClient\Tests\Unit\Client;

use Brotkrueml\JobRouterClient\Client\ClientInterface;
use Brotkrueml\JobRouterClient\Client\IncidentsClientDecorator;
use Brotkrueml\JobRouterClient\Model\Incident;
use Brotkrueml\JobRouterClient\Resource\FileInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class IncidentsClientDecoratorTest extends TestCase
{
    /** @var ClientInterface|MockObject */
    private $clientMock;

    /** @var IncidentsClientDecorator */
    private $subject;

    protected function setUp(): void
    {
        $this->clientMock = $this->createMock(ClientInterface::class);

        $this->subject = new IncidentsClientDecorator($this->clientMock);
    }

    /**
     * @test
     */
    public function requestIsPassedUnchangedToClientIfArrayIsGivenAsDataAndReturnsInstanceOfResponseInterface(): void
    {
        $responseStub = $this->createStub(ResponseInterface::class);

        $this->clientMock
            ->expects(self::once())
            ->method('request')
            ->with('GET', 'some/route', ['some' => 'data'])
            ->willReturn($responseStub);

        $actual = $this->subject->request('GET', 'some/route', ['some' => 'data']);

        self::assertInstanceOf(ResponseInterface::class, $actual);
    }

    /**
     * @test
     * @dataProvider dataProvider
     * @param Incident $incident
     * @param array $withMultipart
     */
    public function requestWithIncidentIsProcessedAsMultipartAndPassedToClient(
        Incident $incident,
        array $withMultipart
    ): void {
        $this->clientMock
            ->expects(self::once())
            ->method('request')
            ->with('POST', 'some/route', ['multipart' => $withMultipart]);

        $this->subject->request('POST', 'some/route', $incident);
    }

    public function dataProvider(): iterable
    {
        yield 'Given step' => [
            (new Incident())->setStep(1),
            ['step' => '1']
        ];

        yield 'Given initiator' => [
            (new Incident())->setInitiator('some initiator'),
            ['initiator' => 'some initiator']
        ];

        yield 'Given username' => [
            (new Incident())->setUsername('some username'),
            ['username' => 'some username']
        ];

        yield 'Given jobfunction' => [
            (new Incident())->setJobfunction('some jobfunction'),
            ['jobfunction' => 'some jobfunction']
        ];

        yield 'Given summary' => [
            (new Incident())->setSummary('some summary'),
            ['summary' => 'some summary']
        ];

        yield 'Given priority' => [
            (new Incident())->setPriority(2),
            ['priority' => '2']
        ];

        yield 'Given pool' => [
            (new Incident())->setPool(42),
            ['pool' => '42']
        ];

        yield 'Given simulation is true' => [
            (new Incident())->setSimulation(true),
            ['simulation' => '1']
        ];

        yield 'Given simulation is false' => [
            (new Incident())->setSimulation(false),
            []
        ];

        yield 'Given step escalation date' => [
            (new Incident())->setStepEscalationDate(
                new \DateTime(
                    '2020-01-30 12:34:56',
                    new \DateTimeZone('America/Chicago')
                )
            ),
            ['step_escalation_date' => '2020-01-30T12:34:56-06:00']
        ];

        yield 'Given incident escalation date' => [
            (new Incident())->setIncidentEscalationDate(
                new \DateTime(
                    '2020-01-31 01:23:45',
                    new \DateTimeZone('Europe/Berlin')
                )
            ),
            ['incident_escalation_date' => '2020-01-31T01:23:45+01:00']
        ];

        $fileStub = $this->createStub(FileInterface::class);
        yield 'Given process table fields' => [
            (new Incident())
                ->setProcessTableField('some field', 'some value')
                ->setProcessTableField('another field', 'another value')
                ->setProcessTableField('different field', 'different value')
                ->setProcessTableField('integer field', 123)
                ->setProcessTableField('file field', $fileStub),
            [
                'processtable[fields][0][name]' => 'some field',
                'processtable[fields][0][value]' => 'some value',
                'processtable[fields][1][name]' => 'another field',
                'processtable[fields][1][value]' => 'another value',
                'processtable[fields][2][name]' => 'different field',
                'processtable[fields][2][value]' => 'different value',
                'processtable[fields][3][name]' => 'integer field',
                'processtable[fields][3][value]' => '123',
                'processtable[fields][4][name]' => 'file field',
                'processtable[fields][4][value]' => $fileStub,
            ]
        ];

        yield 'Given sub table fields' => [
            (new Incident())
                ->setRowsForSubTable(
                    'some subtable',
                    [
                        [
                            'some name 1/1' => 'some value 1/1',
                            'some name 1/2' => 'some value 1/2',
                        ],
                        [
                            'some name 2/1' => 'some value 2/1',
                            'some name 2/2' => 'some value 2/2',
                        ],
                    ]
                )
                ->setRowsForSubTable(
                    'other subtable',
                    [
                        [
                            'other name 1/1' => 'other value 1/1',
                            'other name 1/2' => 'other value 1/2',
                        ],
                    ]
                ),
            [
                'subtables[0][name]' => 'some subtable',
                'subtables[0][rows][0][fields][0][name]' => 'some name 1/1',
                'subtables[0][rows][0][fields][0][value]' => 'some value 1/1',
                'subtables[0][rows][0][fields][1][name]' => 'some name 1/2',
                'subtables[0][rows][0][fields][1][value]' => 'some value 1/2',
                'subtables[0][rows][1][fields][0][name]' => 'some name 2/1',
                'subtables[0][rows][1][fields][0][value]' => 'some value 2/1',
                'subtables[0][rows][1][fields][1][name]' => 'some name 2/2',
                'subtables[0][rows][1][fields][1][value]' => 'some value 2/2',
                'subtables[1][name]' => 'other subtable',
                'subtables[1][rows][0][fields][0][name]' => 'other name 1/1',
                'subtables[1][rows][0][fields][0][value]' => 'other value 1/1',
                'subtables[1][rows][0][fields][1][name]' => 'other name 1/2',
                'subtables[1][rows][0][fields][1][value]' => 'other value 1/2',
            ]
        ];
    }

    /**
     * @test
     */
    public function requestWithIncidentIsProcessedAndReturnsInstanceOfResponseInterface(): void
    {
        $responseStub = $this->createStub(ResponseInterface::class);

        $this->clientMock
            ->expects(self::once())
            ->method('request')
            ->willReturn($responseStub);

        $actual = $this->subject->request('GET', 'some/route', new Incident());

        self::assertInstanceOf(ResponseInterface::class, $actual);
    }
}
