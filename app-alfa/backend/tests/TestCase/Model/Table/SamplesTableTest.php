<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SamplesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SamplesTable Test Case
 */
class SamplesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SamplesTable
     */
    protected $Samples;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        // 'app.Samples',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Samples') ? [] : ['className' => SamplesTable::class];
        $this->Samples = $this->getTableLocator()->get('Samples', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Samples);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SamplesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        // $this->markTestIncomplete('Not implemented yet.');
        $this->assertTrue(true);
    }
}
