<?php
namespace Tests\Unit;

use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Requests\API\V1\Category\CreateRequest;
use App\Http\Resources\V1\Category\CategoryResource;
use App\Managers\Category\CategoryManager;
use App\Services\Category\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerUnitTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function test_create_category()
    {
        $request = $this->getMockBuilder(CreateRequest::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request->expects($this->once())
            ->method('getSlug')
            ->willReturn('slug-3');

        $request->expects($this->once())
            ->method('getParentId')
            ->willReturn(1);

        $nameTranslations = [
            'en' => 'name test en',
            'hy' => 'name test hy',
        ];

        $request->expects($this->once())
            ->method('getNameTranslations')
            ->willReturn($nameTranslations);

        $controller = new CategoryController(new CategoryManager(new CategoryService()));

        $response = $controller->createAction($request);

        $this->assertInstanceOf(CategoryResource::class, $response);
        $this->assertEquals($response['id'], $response->resource->id);
        $this->assertEquals($response['name'], $response->resource->name);
    }

}
