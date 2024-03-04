<?php

namespace Tests\Unit\Services;

use App\Models\Sale;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\ProductStockRepositoryInterface;
use App\Repositories\Interfaces\SaleProductRepositoryInterface;
use App\Repositories\Interfaces\SaleRepositoryInterface;
use App\Services\ProductService;
use App\Services\SaleService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use PHPUnit\Framework\TestCase;
use ArrayIterator;

class SaleServiceTest extends TestCase
{
    protected $saleRepositoryMock;
    protected $productServiceMock;
    protected $productStockRepositoryMock;
    protected $productRepositoryMock;
    protected $saleProductRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productServiceMock = $this->getMockBuilder(ProductService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->saleRepositoryMock = $this->createMock(SaleRepositoryInterface::class);
        $this->productStockRepositoryMock = $this->createMock(ProductStockRepositoryInterface::class);
        $this->productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $this->saleProductRepositoryMock = $this->createMock(SaleProductRepositoryInterface::class);
    }

    public function testPaginateSales(): void
    {
        $paginatorMock = Mockery::mock(LengthAwarePaginator::class);

        $paginatorMock->shouldReceive('getIterator')->andReturn(new ArrayIterator([]));
        $paginatorMock->shouldReceive('currentPage')->andReturn(1);
        $paginatorMock->shouldReceive('url')->with(1)->andReturn('http://example.com?page=1');
        $paginatorMock->shouldReceive('firstItem')->andReturn(1);
        $paginatorMock->shouldReceive('lastPage')->andReturn(1);
        $paginatorMock->shouldReceive('nextPageUrl')->andReturnNull();
        $paginatorMock->shouldReceive('path')->andReturn('http://example.com');
        $paginatorMock->shouldReceive('perPage')->andReturn(10);
        $paginatorMock->shouldReceive('previousPageUrl')->andReturnNull();
        $paginatorMock->shouldReceive('lastItem')->andReturn(1);
        $paginatorMock->shouldReceive('total')->andReturn(1);

        $this->saleRepositoryMock
            ->expects($this->once())
            ->method('paginate')
            ->with(10, 1)
            ->willReturn($paginatorMock);

        $saleService = new SaleService(
            $this->saleRepositoryMock,
            $this->productServiceMock,
            $this->productStockRepositoryMock,
            $this->productRepositoryMock,
            $this->saleProductRepositoryMock
        );

        $result = $saleService->paginateSales(10, 1);

        $this->assertIsArray($result['data']);
    }

    public function testGetSale(): void
    {
        $saleId = 1;
        $saleMock = Mockery::mock(Sale::class);
        $saleMock->shouldReceive('getAttribute')->with('id')->andReturn($saleId);
        $saleMock->shouldReceive('getAttribute')->with('price')->andReturn(50.00);
        $saleMock->shouldReceive('getAttribute')->with('products')->andReturn(new Collection([
            (object) ['id' => 1, 'name' => 'Product 1', 'price' => 10.00, 'pivot' => (object) ['amount' => 2]],
            (object) ['id' => 2, 'name' => 'Product 2', 'price' => 20.00, 'pivot' => (object) ['amount' => 1]],
        ]));

        $this->saleRepositoryMock
            ->expects($this->once())
            ->method('find')
            ->with($saleId)
            ->willReturn($saleMock);

        $saleService = new SaleService(
            $this->saleRepositoryMock,
            $this->productServiceMock,
            $this->productStockRepositoryMock,
            $this->productRepositoryMock,
            $this->saleProductRepositoryMock
        );

        $result = $saleService->getSale($saleId);

        $this->assertEquals($saleId, $result['sales_id']);
        $this->assertEquals(50.00, $result['amount']);
        $this->assertCount(2, $result['products']);
    }
}
