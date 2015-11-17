<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Elasticsearch\Test\Unit\Model\Client;

use Magento\Elasticsearch\Model\Client\Elasticsearch as ElasticsearchClient;
use Elasticsearch\Common\Exceptions\Missing404Exception;

class ElasticsearchTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ElasticsearchClient
     */
    protected $model;

    /**
     * @var \Elasticsearch\Client|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $elasticsearchClientMock;

    /**
     * @var \Elasticsearch\Namespaces\IndicesNamespace|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $indicesMock;

    /**
     * Setup
     *
     * @return void
     */
    public function setUp()
    {
        $this->elasticsearchClientMock = $this->getMockBuilder('\Elasticsearch\Client')
            ->setMethods([
                'indices',
                'ping',
                'bulk',
                'deleteByQuery',
            ])
            ->disableOriginalConstructor()
            ->getMock();
        $this->indicesMock = $this->getMockBuilder('\Elasticsearch\Namespaces\IndicesNamespace')
            ->setMethods([
                'exists',
                'getSettings',
                'create',
                'putMapping',
                'deleteMapping',
            ])
            ->disableOriginalConstructor()
            ->getMock();
        $this->elasticsearchClientMock->expects($this->any())
            ->method('indices')
            ->willReturn($this->indicesMock);

        $this->model = new ElasticsearchClient($this->getOptions(), $this->elasticsearchClientMock);
    }

    /**
     * @expectedException \Magento\Framework\Exception\LocalizedException
     */
    public function testConstructorOptionsException()
    {
        new ElasticsearchClient([]);
    }

    /**
     * Test client creation from the list of options
     */
    public function testConstructorWithOptions()
    {
        new ElasticsearchClient($this->getOptions());
    }

    /**
     * Test ping functionality
     */
    public function testPing()
    {
        $this->elasticsearchClientMock->expects($this->once())->method('ping')->willReturn(true);
        $this->assertEquals(true, $this->model->ping());
    }

    /**
     * Test validation of connection parameters
     */
    public function testTestConnection()
    {
        $this->indicesMock->expects($this->once())->method('exists')->willReturn(true);
        $this->assertEquals(true, $this->model->testConnection());
    }

    /**
     * Test addDocuments() method
     */
    public function testAddDocuments()
    {
        $this->elasticsearchClientMock->expects($this->once())
            ->method('bulk');
        $this->model->addDocuments([]);
    }

    /**
     * Test deleteDocumentsFromIndex() method
     */
    public function testDeleteDocumentsFromIndex()
    {
        $this->elasticsearchClientMock->expects($this->once())
            ->method('deleteByQuery')
            ->with([
                'index' => 'indexName',
                'type' => 'product',
                'body' => [
                    'query' => [
                        'match_all' => [],
                    ],
                ],
            ]);
        $this->model->deleteDocumentsFromIndex('indexName', 'product');
    }

    /**
     * Test deleteDocumentsByIds() method
     */
    public function testDeleteDocumentsByIds()
    {
        $this->elasticsearchClientMock->expects($this->once())
            ->method('deleteByQuery')
            ->with([
                'index' => 'indexName',
                'type' => 'product',
                'body' => [
                    'query' => [
                        'ids' => [
                            'type' => 'product',
                            'values' => [
                                1,
                            ],
                        ],
                    ],
                ],
            ]);
        $this->model->deleteDocumentsByIds([1], 'indexName', 'product');
    }

    /**
     * Test createIndexIfNotExists() method, case when such index exists
     */
    public function testCreateIndexExists()
    {
        $this->indicesMock->expects($this->once())
            ->method('getSettings')
            ->with([
                'index' => 'indexName',
            ]);
        $this->assertEquals(
            false,
            $this->model->createIndexIfNotExists('indexName')
        );
    }

    /**
     * Test createIndexIfNotExists() method, case when no such index exists
     */
    public function testCreateIndexNotExists()
    {
        $this->indicesMock->expects($this->once())
            ->method('getSettings')
            ->with([
                'index' => 'indexName',
            ])
            ->willThrowException(new Missing404Exception());
        $this->indicesMock->expects($this->once())
            ->method('create')
            ->with([
                'index' => 'indexName',
            ]);
        $this->assertEquals(
            true,
            $this->model->createIndexIfNotExists('indexName')
        );
    }

    /**
     * Test createIndexIfNotExists() method, case when operation fails
     * @expectedException \Exception
     */
    public function testCreateIndexFailure()
    {
        $this->indicesMock->expects($this->once())
            ->method('getSettings')
            ->with([
                'index' => 'indexName',
            ])
            ->willThrowException(new \Exception('Something went wrong'));
        $this->model->createIndexIfNotExists('indexName');
    }

    /**
     * Test testAddFieldsMapping() method
     */
    public function testAddFieldsMapping()
    {
        $this->indicesMock->expects($this->once())
            ->method('putMapping')
            ->with([
                'index' => 'indexName',
                'type' => 'product',
                'body' => [
                    'product' => [
                        '_all' => [
                            'enabled' => true,
                            'type' => 'string'
                        ],
                        'properties' => [
                            'name' => [
                                'type' => 'string',
                            ],
                        ],
                    ],
                ],
            ]);
        $this->model->addFieldsMapping(
            [
                'name' => [
                    'type' => 'string',
                ],
            ],
            'indexName',
            'product'
        );
    }

    /**
     * Test testAddFieldsMapping() method
     * @expectedException \Exception
     */
    public function testAddFieldsMappingFailure()
    {
        $this->indicesMock->expects($this->once())
            ->method('putMapping')
            ->with([
                'index' => 'indexName',
                'type' => 'product',
                'body' => [
                    'product' => [
                        '_all' => [
                            'enabled' => true,
                            'type' => 'string'
                        ],
                        'properties' => [
                            'name' => [
                                'type' => 'string',
                            ],
                        ],
                    ],
                ],
            ])
            ->willThrowException(new \Exception('Something went wrong'));
        $this->model->addFieldsMapping(
            [
                'name' => [
                    'type' => 'string',
                ],
            ],
            'indexName',
            'product'
        );
    }

    /**
     * Test deleteMapping() method
     */
    public function testDeleteMapping()
    {
        $this->indicesMock->expects($this->once())
            ->method('deleteMapping')
            ->with([
                'index' => 'indexName',
                'type' => 'product',
            ]);
        $this->model->deleteMapping(
            'indexName',
            'product'
        );
    }

    /**
     * Test deleteMapping() method
     * @expectedException \Exception
     */
    public function testDeleteMappingFailure()
    {
        $this->indicesMock->expects($this->once())
            ->method('deleteMapping')
            ->with([
                'index' => 'indexName',
                'type' => 'product',
            ])
            ->willThrowException(new \Exception('Something went wrong'));
        $this->model->deleteMapping(
            'indexName',
            'product'
        );
    }

    /**
     * Get elasticsearch client options
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            'hostname' => 'localhost',
            'port' => '9200',
            'timeout' => 15,
            'index' => 'magento2',
            'enableAuth' => 1,
            'username' => 'user',
            'password' => 'passwd',
        ];
    }
}
