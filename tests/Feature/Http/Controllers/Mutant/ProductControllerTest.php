<?php

namespace Tests\Feature\Http\Controllers\Mutant;

use App\Http\Controllers\Mutant\ProductController;
use App\Http\Controllers\Renewed\ProductController as RenewedProductController;
use App\Product;
use App\User;
use Illuminate\Auth\RequestGuard;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class ProductControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function getTestCasesStore()
    {
        $path = __DIR__ . "/../TestCases/productController_store.json";
        $testCasesJSON = file_get_contents($path);
        $decodedTestCases = json_decode($testCasesJSON, true);

        $testCases = [];
        foreach ($decodedTestCases as $dtc) {
            $testName = $dtc['test_name'];
            $testData = $dtc['test_data'];
            $expectedResult = $dtc['test_expected_result'];
            $testCases[$testName] = [$testData, $expectedResult];
        }

        return $testCases;
    }

    /**
     * @test
     * @dataProvider getTestCasesStore
     */
    public function testMutantStore1($testData, $expectedResult)
    {
        if ($testData['merchant'] != null) {
            // define mock data
            // mock merchant
            $mockMerchant = factory(User::class)->create($testData['merchant']);
            // login as merchant
            $this->actingAs($mockMerchant);
        }

        // define parameters
        $paramRequest = new Request();
        $paramRequest->replace($testData['request']['product']);
        $paramId = $testData['request']['id_product_type'];

        // call function
        $storedProduct = (new ProductController())->mutantStore1($paramRequest, $paramId);
        if (!$expectedResult['is_error']) {
            $this->assertNotEmpty($storedProduct);

            // define expected result
            $expectedProduct = new Product($expectedResult['product']);
            $expectedProduct->user_id = $mockMerchant->id;
            $expectedProduct->images = $expectedResult['product']['images'];
            $expectedProduct->asal = $expectedResult['product']['asal'];

            // assert value
            $this->assertEquals($expectedProduct->name, $storedProduct->name);
            $this->assertEquals($expectedProduct->price, $storedProduct->price);
            $this->assertEquals($expectedProduct->images, $storedProduct->images);
            $this->assertEquals($expectedProduct->stock, $storedProduct->stock);
            $this->assertEquals($expectedProduct->description, $storedProduct->description);
            $this->assertEquals($expectedProduct->specification, $storedProduct->specification);
            $this->assertEquals($expectedProduct->asal, $storedProduct->asal);
            $this->assertEquals($expectedProduct->color, $storedProduct->color);
            $this->assertEquals($expectedProduct->user_id, $storedProduct->user_id);
            $this->assertEquals($expectedProduct->sold, $storedProduct->sold);
        } else {
            $this->assertEmpty($storedProduct);
        }
    }

    /**
     * @test
     * @dataProvider getTestCasesStore
     */
    public function testMutantStore2($testData, $expectedResult)
    {
        if ($testData['merchant'] != null) {
            // define mock data
            // mock merchant
            $mockMerchant = factory(User::class)->create($testData['merchant']);
            // login as merchant
            $this->actingAs($mockMerchant);
        }

        // define parameters
        $paramRequest = new Request();
        $paramRequest->replace($testData['request']['product']);
        $paramId = $testData['request']['id_product_type'];

        // call function
        $storedProduct = (new ProductController())->mutantStore2($paramRequest, $paramId);
        if (!$expectedResult['is_error']) {
            $this->assertNotEmpty($storedProduct);

            // define expected result
            $expectedProduct = new Product($expectedResult['product']);
            $expectedProduct->user_id = $mockMerchant->id;
            $expectedProduct->images = $expectedResult['product']['images'];
            $expectedProduct->asal = $expectedResult['product']['asal'];

            // assert value
            $this->assertEquals($expectedProduct->name, $storedProduct->name);
            $this->assertEquals($expectedProduct->price, $storedProduct->price);
            $this->assertEquals($expectedProduct->images, $storedProduct->images);
            $this->assertEquals($expectedProduct->stock, $storedProduct->stock);
            $this->assertEquals($expectedProduct->description, $storedProduct->description);
            $this->assertEquals($expectedProduct->specification, $storedProduct->specification);
            $this->assertEquals($expectedProduct->asal, $storedProduct->asal);
            $this->assertEquals($expectedProduct->color, $storedProduct->color);
            $this->assertEquals($expectedProduct->user_id, $storedProduct->user_id);
            $this->assertEquals($expectedProduct->sold, $storedProduct->sold);
        } else {
            $this->assertEmpty($storedProduct);
        }
    }

    /**
     * @test
     * @dataProvider getTestCasesStore
     */
    public function testMutantStore3($testData, $expectedResult)
    {
        if ($testData['merchant'] != null) {
            // define mock data
            // mock merchant
            $mockMerchant = factory(User::class)->create($testData['merchant']);
            // login as merchant
            $this->actingAs($mockMerchant);
        }

        // define parameters
        $paramRequest = new Request();
        $paramRequest->replace($testData['request']['product']);
        $paramId = $testData['request']['id_product_type'];

        // call function
        $storedProduct = (new ProductController())->mutantStore3($paramRequest, $paramId);
        if (!$expectedResult['is_error']) {
            $this->assertNotEmpty($storedProduct);

            // define expected result
            $expectedProduct = new Product($expectedResult['product']);
            $expectedProduct->user_id = $mockMerchant->id;
            $expectedProduct->images = $expectedResult['product']['images'];
            $expectedProduct->asal = $expectedResult['product']['asal'];

            // assert value
            $this->assertEquals($expectedProduct->name, $storedProduct->name);
            $this->assertEquals($expectedProduct->price, $storedProduct->price);
            $this->assertEquals($expectedProduct->images, $storedProduct->images);
            $this->assertEquals($expectedProduct->stock, $storedProduct->stock);
            $this->assertEquals($expectedProduct->description, $storedProduct->description);
            $this->assertEquals($expectedProduct->specification, $storedProduct->specification);
            $this->assertEquals($expectedProduct->asal, $storedProduct->asal);
            $this->assertEquals($expectedProduct->color, $storedProduct->color);
            $this->assertEquals($expectedProduct->user_id, $storedProduct->user_id);
            $this->assertEquals($expectedProduct->sold, $storedProduct->sold);
        } else {
            $this->assertEmpty($storedProduct);
        }
    }

    /**
     * @test
     * @dataProvider getTestCasesStore
     */
    public function testMutantStore4($testData, $expectedResult)
    {
        if ($testData['merchant'] != null) {
            // define mock data
            // mock merchant
            $mockMerchant = factory(User::class)->create($testData['merchant']);
            // login as merchant
            $this->actingAs($mockMerchant);
        }

        // define parameters
        $paramRequest = new Request();
        $paramRequest->replace($testData['request']['product']);
        $paramId = $testData['request']['id_product_type'];

        // call function
        $storedProduct = (new ProductController())->mutantStore4($paramRequest, $paramId);
        if (!$expectedResult['is_error']) {
            $this->assertNotEmpty($storedProduct);

            // define expected result
            $expectedProduct = new Product($expectedResult['product']);
            $expectedProduct->user_id = $mockMerchant->id;
            $expectedProduct->images = $expectedResult['product']['images'];
            $expectedProduct->asal = $expectedResult['product']['asal'];

            // assert value
            $this->assertEquals($expectedProduct->name, $storedProduct->name);
            $this->assertEquals($expectedProduct->price, $storedProduct->price);
            $this->assertEquals($expectedProduct->images, $storedProduct->images);
            $this->assertEquals($expectedProduct->stock, $storedProduct->stock);
            $this->assertEquals($expectedProduct->description, $storedProduct->description);
            $this->assertEquals($expectedProduct->specification, $storedProduct->specification);
            $this->assertEquals($expectedProduct->asal, $storedProduct->asal);
            $this->assertEquals($expectedProduct->color, $storedProduct->color);
            $this->assertEquals($expectedProduct->user_id, $storedProduct->user_id);
            $this->assertEquals($expectedProduct->sold, $storedProduct->sold);
        } else {
            $this->assertEmpty($storedProduct);
        }
    }

    /**
     * @test
     * @dataProvider getTestCasesStore
     */
    public function testMutantStore5($testData, $expectedResult)
    {
        if ($testData['merchant'] != null) {
            // define mock data
            // mock merchant
            $mockMerchant = factory(User::class)->create($testData['merchant']);
            // login as merchant
            $this->actingAs($mockMerchant);
        }

        // define parameters
        $paramRequest = new Request();
        $paramRequest->replace($testData['request']['product']);
        $paramId = $testData['request']['id_product_type'];

        // call function
        $storedProduct = (new ProductController())->mutantStore5($paramRequest, $paramId);
        if (!$expectedResult['is_error']) {
            $this->assertNotEmpty($storedProduct);

            // define expected result
            $expectedProduct = new Product($expectedResult['product']);
            $expectedProduct->user_id = $mockMerchant->id;
            $expectedProduct->images = $expectedResult['product']['images'];
            $expectedProduct->asal = $expectedResult['product']['asal'];

            // assert value
            $this->assertEquals($expectedProduct->name, $storedProduct->name);
            $this->assertEquals($expectedProduct->price, $storedProduct->price);
            $this->assertEquals($expectedProduct->images, $storedProduct->images);
            $this->assertEquals($expectedProduct->stock, $storedProduct->stock);
            $this->assertEquals($expectedProduct->description, $storedProduct->description);
            $this->assertEquals($expectedProduct->specification, $storedProduct->specification);
            $this->assertEquals($expectedProduct->asal, $storedProduct->asal);
            $this->assertEquals($expectedProduct->color, $storedProduct->color);
            $this->assertEquals($expectedProduct->user_id, $storedProduct->user_id);
            $this->assertEquals($expectedProduct->sold, $storedProduct->sold);
        } else {
            $this->assertEmpty($storedProduct);
        }
    }

    /**
     * @test
     * @dataProvider getTestCasesStore
     */
    public function testMutantStore6($testData, $expectedResult)
    {
        if ($testData['merchant'] != null) {
            // define mock data
            // mock merchant
            $mockMerchant = factory(User::class)->create($testData['merchant']);
            // login as merchant
            $this->actingAs($mockMerchant);
        }

        // define parameters
        $paramRequest = new Request();
        $paramRequest->replace($testData['request']['product']);
        $paramId = $testData['request']['id_product_type'];

        // call function
        $storedProduct = (new ProductController())->mutantStore6($paramRequest, $paramId);
        if (!$expectedResult['is_error']) {
            $this->assertNotEmpty($storedProduct);

            // define expected result
            $expectedProduct = new Product($expectedResult['product']);
            $expectedProduct->user_id = $mockMerchant->id;
            $expectedProduct->images = $expectedResult['product']['images'];
            $expectedProduct->asal = $expectedResult['product']['asal'];

            // assert value
            $this->assertEquals($expectedProduct->name, $storedProduct->name);
            $this->assertEquals($expectedProduct->price, $storedProduct->price);
            $this->assertEquals($expectedProduct->images, $storedProduct->images);
            $this->assertEquals($expectedProduct->stock, $storedProduct->stock);
            $this->assertEquals($expectedProduct->description, $storedProduct->description);
            $this->assertEquals($expectedProduct->specification, $storedProduct->specification);
            $this->assertEquals($expectedProduct->asal, $storedProduct->asal);
            $this->assertEquals($expectedProduct->color, $storedProduct->color);
            $this->assertEquals($expectedProduct->user_id, $storedProduct->user_id);
            $this->assertEquals($expectedProduct->sold, $storedProduct->sold);
        } else {
            $this->assertEmpty($storedProduct);
        }
    }

    /**
     * @test
     * @dataProvider getTestCasesStore
     */
    public function testMutantStore7($testData, $expectedResult)
    {
        if ($testData['merchant'] != null) {
            // define mock data
            // mock merchant
            $mockMerchant = factory(User::class)->create($testData['merchant']);
            // login as merchant
            $this->actingAs($mockMerchant);
        }

        // define parameters
        $paramRequest = new Request();
        $paramRequest->replace($testData['request']['product']);
        $paramId = $testData['request']['id_product_type'];

        // call function
        $storedProduct = (new ProductController())->mutantStore7($paramRequest, $paramId);
        if (!$expectedResult['is_error']) {
            $this->assertNotEmpty($storedProduct);

            // define expected result
            $expectedProduct = new Product($expectedResult['product']);
            $expectedProduct->user_id = $mockMerchant->id;
            $expectedProduct->images = $expectedResult['product']['images'];
            $expectedProduct->asal = $expectedResult['product']['asal'];

            // assert value
            $this->assertEquals($expectedProduct->name, $storedProduct->name);
            $this->assertEquals($expectedProduct->price, $storedProduct->price);
            $this->assertEquals($expectedProduct->images, $storedProduct->images);
            $this->assertEquals($expectedProduct->stock, $storedProduct->stock);
            $this->assertEquals($expectedProduct->description, $storedProduct->description);
            $this->assertEquals($expectedProduct->specification, $storedProduct->specification);
            $this->assertEquals($expectedProduct->asal, $storedProduct->asal);
            $this->assertEquals($expectedProduct->color, $storedProduct->color);
            $this->assertEquals($expectedProduct->user_id, $storedProduct->user_id);
            $this->assertEquals($expectedProduct->sold, $storedProduct->sold);
        } else {
            $this->assertEmpty($storedProduct);
        }
    }

    /**
     * @test
     * @dataProvider getTestCasesStore
     */
    public function testMutantStore8($testData, $expectedResult)
    {
        if ($testData['merchant'] != null) {
            // define mock data
            // mock merchant
            $mockMerchant = factory(User::class)->create($testData['merchant']);
            // login as merchant
            $this->actingAs($mockMerchant);
        }

        // define parameters
        $paramRequest = new Request();
        $paramRequest->replace($testData['request']['product']);
        $paramId = $testData['request']['id_product_type'];

        // call function
        $storedProduct = (new ProductController())->mutantStore8($paramRequest, $paramId);
        if (!$expectedResult['is_error']) {
            $this->assertNotEmpty($storedProduct);

            // define expected result
            $expectedProduct = new Product($expectedResult['product']);
            $expectedProduct->user_id = $mockMerchant->id;
            $expectedProduct->images = $expectedResult['product']['images'];
            $expectedProduct->asal = $expectedResult['product']['asal'];

            // assert value
            $this->assertEquals($expectedProduct->name, $storedProduct->name);
            $this->assertEquals($expectedProduct->price, $storedProduct->price);
            $this->assertEquals($expectedProduct->images, $storedProduct->images);
            $this->assertEquals($expectedProduct->stock, $storedProduct->stock);
            $this->assertEquals($expectedProduct->description, $storedProduct->description);
            $this->assertEquals($expectedProduct->specification, $storedProduct->specification);
            $this->assertEquals($expectedProduct->asal, $storedProduct->asal);
            $this->assertEquals($expectedProduct->color, $storedProduct->color);
            $this->assertEquals($expectedProduct->user_id, $storedProduct->user_id);
            $this->assertEquals($expectedProduct->sold, $storedProduct->sold);
        } else {
            $this->assertEmpty($storedProduct);
        }
    }

    public function getTestCasesUpdate()
    {
        $path = __DIR__ . "/../TestCases/productController_update.json";
        $testCasesJSON = file_get_contents($path);
        $decodedTestCases = json_decode($testCasesJSON, true);

        $path = __DIR__ . "/../TestCases/sample_products.json";
        $sampleProductsJSON = file_get_contents($path);
        $sampleProducts = json_decode($sampleProductsJSON, true);

        $testCases = [];
        foreach ($decodedTestCases as $dtc) {
            $testName = $dtc['test_name'];
            $testData = $dtc['test_data'];
            $expectedResult = $dtc['test_expected_result'];
            $testCases[$testName] = [$testData, $expectedResult, $sampleProducts];
        }

        return $testCases;
    }

    /**
     * @test
     * @dataProvider getTestCasesUpdate
     */
    public function testMutantUpdate1($testData, $expectedResult, $sampleProducts)
    {
        $dataMerchant = ['username' => 'merchant'];
        if ($testData['merchant'] != null) {
            $dataMerchant = $testData['merchant'];
        }

        // define mock data
        // mock merchant
        $mockMerchant = factory(User::class)->create($dataMerchant);
        $this->actingAs($mockMerchant);

        // define store request parameters
        $paramStoreRequest = new Request();
        $paramStoreRequest->replace($sampleProducts[$testData['request']['current_product']]);
        $sampleProductTypeId = $testData['request']['id_product_type'];

        // store sample current product
        $currentProduct = (new RenewedProductController())->store($paramStoreRequest, $sampleProductTypeId);
        $this->assertNotEmpty($currentProduct);

        RequestGuard::macro('logout', function() {
            $this->user = null;
        });
        $this->app['auth']->logout();

        if ($testData['merchant'] != null) {
            $this->actingAs($mockMerchant);
        }

        // define update request parameters
        $paramUpdateRequest = new Request();
        $paramUpdateRequest->replace($testData['request']['product']);

        // call function
        $updatedProduct = (new ProductController())->mutantUpdate1($paramUpdateRequest, $currentProduct->id);
        if (!$expectedResult['is_error']) {
            $this->assertNotEmpty($updatedProduct);

            // define expected result
            $expectedProduct = new Product($expectedResult['product']);
            $expectedProduct->user_id = $mockMerchant->id;
            $expectedProduct->images = $expectedResult['product']['images'];
            $expectedProduct->asal = $expectedResult['product']['asal'];

            // assert value
            $this->assertEquals($expectedProduct->name, $updatedProduct->name);
            $this->assertEquals($expectedProduct->price, $updatedProduct->price);
            $this->assertEquals($expectedProduct->images, $updatedProduct->images);
            $this->assertEquals($expectedProduct->stock, $updatedProduct->stock);
            $this->assertEquals($expectedProduct->description, $updatedProduct->description);
            $this->assertEquals($expectedProduct->specification, $updatedProduct->specification);
            $this->assertEquals($expectedProduct->asal, $updatedProduct->asal);
            $this->assertEquals($expectedProduct->color, $updatedProduct->color);
            $this->assertEquals($expectedProduct->user_id, $updatedProduct->user_id);
            $this->assertEquals($expectedProduct->sold, $updatedProduct->sold);
        } else {
            $this->assertEmpty($updatedProduct);
        }
    }

    /**
     * @test
     * @dataProvider getTestCasesUpdate
     */
    public function testMutantUpdate2($testData, $expectedResult, $sampleProducts)
    {
        $dataMerchant = ['username' => 'merchant'];
        if ($testData['merchant'] != null) {
            $dataMerchant = $testData['merchant'];
        }

        // define mock data
        // mock merchant
        $mockMerchant = factory(User::class)->create($dataMerchant);
        $this->actingAs($mockMerchant);

        // define store request parameters
        $paramStoreRequest = new Request();
        $paramStoreRequest->replace($sampleProducts[$testData['request']['current_product']]);
        $sampleProductTypeId = $testData['request']['id_product_type'];

        // store sample current product
        $currentProduct = (new RenewedProductController())->store($paramStoreRequest, $sampleProductTypeId);
        $this->assertNotEmpty($currentProduct);

        RequestGuard::macro('logout', function() {
            $this->user = null;
        });
        $this->app['auth']->logout();

        if ($testData['merchant'] != null) {
            $this->actingAs($mockMerchant);
        }

        // define update request parameters
        $paramUpdateRequest = new Request();
        $paramUpdateRequest->replace($testData['request']['product']);

        // call function
        $updatedProduct = (new ProductController())->mutantUpdate2($paramUpdateRequest, $currentProduct->id);
        if (!$expectedResult['is_error']) {
            $this->assertNotEmpty($updatedProduct);

            // define expected result
            $expectedProduct = new Product($expectedResult['product']);
            $expectedProduct->user_id = $mockMerchant->id;
            $expectedProduct->images = $expectedResult['product']['images'];
            $expectedProduct->asal = $expectedResult['product']['asal'];

            // assert value
            $this->assertEquals($expectedProduct->name, $updatedProduct->name);
            $this->assertEquals($expectedProduct->price, $updatedProduct->price);
            $this->assertEquals($expectedProduct->images, $updatedProduct->images);
            $this->assertEquals($expectedProduct->stock, $updatedProduct->stock);
            $this->assertEquals($expectedProduct->description, $updatedProduct->description);
            $this->assertEquals($expectedProduct->specification, $updatedProduct->specification);
            $this->assertEquals($expectedProduct->asal, $updatedProduct->asal);
            $this->assertEquals($expectedProduct->color, $updatedProduct->color);
            $this->assertEquals($expectedProduct->user_id, $updatedProduct->user_id);
            $this->assertEquals($expectedProduct->sold, $updatedProduct->sold);
        } else {
            $this->assertEmpty($updatedProduct);
        }
    }

    /**
     * @test
     * @dataProvider getTestCasesUpdate
     */
    public function testMutantUpdate3($testData, $expectedResult, $sampleProducts)
    {
        $dataMerchant = ['username' => 'merchant'];
        if ($testData['merchant'] != null) {
            $dataMerchant = $testData['merchant'];
        }

        // define mock data
        // mock merchant
        $mockMerchant = factory(User::class)->create($dataMerchant);
        $this->actingAs($mockMerchant);

        // define store request parameters
        $paramStoreRequest = new Request();
        $paramStoreRequest->replace($sampleProducts[$testData['request']['current_product']]);
        $sampleProductTypeId = $testData['request']['id_product_type'];

        // store sample current product
        $currentProduct = (new RenewedProductController())->store($paramStoreRequest, $sampleProductTypeId);
        $this->assertNotEmpty($currentProduct);

        RequestGuard::macro('logout', function() {
            $this->user = null;
        });
        $this->app['auth']->logout();

        if ($testData['merchant'] != null) {
            $this->actingAs($mockMerchant);
        }

        // define update request parameters
        $paramUpdateRequest = new Request();
        $paramUpdateRequest->replace($testData['request']['product']);

        // call function
        $updatedProduct = (new ProductController())->mutantUpdate3($paramUpdateRequest, $currentProduct->id);
        if (!$expectedResult['is_error']) {
            $this->assertNotEmpty($updatedProduct);

            // define expected result
            $expectedProduct = new Product($expectedResult['product']);
            $expectedProduct->user_id = $mockMerchant->id;
            $expectedProduct->images = $expectedResult['product']['images'];
            $expectedProduct->asal = $expectedResult['product']['asal'];

            // assert value
            $this->assertEquals($expectedProduct->name, $updatedProduct->name);
            $this->assertEquals($expectedProduct->price, $updatedProduct->price);
            $this->assertEquals($expectedProduct->images, $updatedProduct->images);
            $this->assertEquals($expectedProduct->stock, $updatedProduct->stock);
            $this->assertEquals($expectedProduct->description, $updatedProduct->description);
            $this->assertEquals($expectedProduct->specification, $updatedProduct->specification);
            $this->assertEquals($expectedProduct->asal, $updatedProduct->asal);
            $this->assertEquals($expectedProduct->color, $updatedProduct->color);
            $this->assertEquals($expectedProduct->user_id, $updatedProduct->user_id);
            $this->assertEquals($expectedProduct->sold, $updatedProduct->sold);
        } else {
            $this->assertEmpty($updatedProduct);
        }
    }

    /**
     * @test
     * @dataProvider getTestCasesUpdate
     */
    public function testMutantUpdate4($testData, $expectedResult, $sampleProducts)
    {
        $dataMerchant = ['username' => 'merchant'];
        if ($testData['merchant'] != null) {
            $dataMerchant = $testData['merchant'];
        }

        // define mock data
        // mock merchant
        $mockMerchant = factory(User::class)->create($dataMerchant);
        $this->actingAs($mockMerchant);

        // define store request parameters
        $paramStoreRequest = new Request();
        $paramStoreRequest->replace($sampleProducts[$testData['request']['current_product']]);
        $sampleProductTypeId = $testData['request']['id_product_type'];

        // store sample current product
        $currentProduct = (new RenewedProductController())->store($paramStoreRequest, $sampleProductTypeId);
        $this->assertNotEmpty($currentProduct);

        RequestGuard::macro('logout', function() {
            $this->user = null;
        });
        $this->app['auth']->logout();

        if ($testData['merchant'] != null) {
            $this->actingAs($mockMerchant);
        }

        // define update request parameters
        $paramUpdateRequest = new Request();
        $paramUpdateRequest->replace($testData['request']['product']);

        // call function
        $updatedProduct = (new ProductController())->mutantUpdate4($paramUpdateRequest, $currentProduct->id);
        if (!$expectedResult['is_error']) {
            $this->assertNotEmpty($updatedProduct);

            // define expected result
            $expectedProduct = new Product($expectedResult['product']);
            $expectedProduct->user_id = $mockMerchant->id;
            $expectedProduct->images = $expectedResult['product']['images'];
            $expectedProduct->asal = $expectedResult['product']['asal'];

            // assert value
            $this->assertEquals($expectedProduct->name, $updatedProduct->name);
            $this->assertEquals($expectedProduct->price, $updatedProduct->price);
            $this->assertEquals($expectedProduct->images, $updatedProduct->images);
            $this->assertEquals($expectedProduct->stock, $updatedProduct->stock);
            $this->assertEquals($expectedProduct->description, $updatedProduct->description);
            $this->assertEquals($expectedProduct->specification, $updatedProduct->specification);
            $this->assertEquals($expectedProduct->asal, $updatedProduct->asal);
            $this->assertEquals($expectedProduct->color, $updatedProduct->color);
            $this->assertEquals($expectedProduct->user_id, $updatedProduct->user_id);
            $this->assertEquals($expectedProduct->sold, $updatedProduct->sold);
        } else {
            $this->assertEmpty($updatedProduct);
        }
    }

    /**
     * @test
     * @dataProvider getTestCasesUpdate
     */
    public function testMutantUpdate5($testData, $expectedResult, $sampleProducts)
    {
        $dataMerchant = ['username' => 'merchant'];
        if ($testData['merchant'] != null) {
            $dataMerchant = $testData['merchant'];
        }

        // define mock data
        // mock merchant
        $mockMerchant = factory(User::class)->create($dataMerchant);
        $this->actingAs($mockMerchant);

        // define store request parameters
        $paramStoreRequest = new Request();
        $paramStoreRequest->replace($sampleProducts[$testData['request']['current_product']]);
        $sampleProductTypeId = $testData['request']['id_product_type'];

        // store sample current product
        $currentProduct = (new RenewedProductController())->store($paramStoreRequest, $sampleProductTypeId);
        $this->assertNotEmpty($currentProduct);

        RequestGuard::macro('logout', function() {
            $this->user = null;
        });
        $this->app['auth']->logout();

        if ($testData['merchant'] != null) {
            $this->actingAs($mockMerchant);
        }

        // define update request parameters
        $paramUpdateRequest = new Request();
        $paramUpdateRequest->replace($testData['request']['product']);

        // call function
        $updatedProduct = (new ProductController())->mutantUpdate5($paramUpdateRequest, $currentProduct->id);
        if (!$expectedResult['is_error']) {
            $this->assertNotEmpty($updatedProduct);

            // define expected result
            $expectedProduct = new Product($expectedResult['product']);
            $expectedProduct->user_id = $mockMerchant->id;
            $expectedProduct->images = $expectedResult['product']['images'];
            $expectedProduct->asal = $expectedResult['product']['asal'];

            // assert value
            $this->assertEquals($expectedProduct->name, $updatedProduct->name);
            $this->assertEquals($expectedProduct->price, $updatedProduct->price);
            $this->assertEquals($expectedProduct->images, $updatedProduct->images);
            $this->assertEquals($expectedProduct->stock, $updatedProduct->stock);
            $this->assertEquals($expectedProduct->description, $updatedProduct->description);
            $this->assertEquals($expectedProduct->specification, $updatedProduct->specification);
            $this->assertEquals($expectedProduct->asal, $updatedProduct->asal);
            $this->assertEquals($expectedProduct->color, $updatedProduct->color);
            $this->assertEquals($expectedProduct->user_id, $updatedProduct->user_id);
            $this->assertEquals($expectedProduct->sold, $updatedProduct->sold);
        } else {
            $this->assertEmpty($updatedProduct);
        }
    }

    /**
     * @test
     * @dataProvider getTestCasesUpdate
     */
    public function testMutantUpdate6($testData, $expectedResult, $sampleProducts)
    {
        $dataMerchant = ['username' => 'merchant'];
        if ($testData['merchant'] != null) {
            $dataMerchant = $testData['merchant'];
        }

        // define mock data
        // mock merchant
        $mockMerchant = factory(User::class)->create($dataMerchant);
        $this->actingAs($mockMerchant);

        // define store request parameters
        $paramStoreRequest = new Request();
        $paramStoreRequest->replace($sampleProducts[$testData['request']['current_product']]);
        $sampleProductTypeId = $testData['request']['id_product_type'];

        // store sample current product
        $currentProduct = (new RenewedProductController())->store($paramStoreRequest, $sampleProductTypeId);
        $this->assertNotEmpty($currentProduct);

        RequestGuard::macro('logout', function() {
            $this->user = null;
        });
        $this->app['auth']->logout();

        if ($testData['merchant'] != null) {
            $this->actingAs($mockMerchant);
        }

        // define update request parameters
        $paramUpdateRequest = new Request();
        $paramUpdateRequest->replace($testData['request']['product']);

        // call function
        $updatedProduct = (new ProductController())->mutantUpdate6($paramUpdateRequest, $currentProduct->id);
        if (!$expectedResult['is_error']) {
            $this->assertNotEmpty($updatedProduct);

            // define expected result
            $expectedProduct = new Product($expectedResult['product']);
            $expectedProduct->user_id = $mockMerchant->id;
            $expectedProduct->images = $expectedResult['product']['images'];
            $expectedProduct->asal = $expectedResult['product']['asal'];

            // assert value
            $this->assertEquals($expectedProduct->name, $updatedProduct->name);
            $this->assertEquals($expectedProduct->price, $updatedProduct->price);
            $this->assertEquals($expectedProduct->images, $updatedProduct->images);
            $this->assertEquals($expectedProduct->stock, $updatedProduct->stock);
            $this->assertEquals($expectedProduct->description, $updatedProduct->description);
            $this->assertEquals($expectedProduct->specification, $updatedProduct->specification);
            $this->assertEquals($expectedProduct->asal, $updatedProduct->asal);
            $this->assertEquals($expectedProduct->color, $updatedProduct->color);
            $this->assertEquals($expectedProduct->user_id, $updatedProduct->user_id);
            $this->assertEquals($expectedProduct->sold, $updatedProduct->sold);
        } else {
            $this->assertEmpty($updatedProduct);
        }
    }

    /**
     * @test
     * @dataProvider getTestCasesUpdate
     */
    public function testMutantUpdate7($testData, $expectedResult, $sampleProducts)
    {
        $dataMerchant = ['username' => 'merchant'];
        if ($testData['merchant'] != null) {
            $dataMerchant = $testData['merchant'];
        }

        // define mock data
        // mock merchant
        $mockMerchant = factory(User::class)->create($dataMerchant);
        $this->actingAs($mockMerchant);

        // define store request parameters
        $paramStoreRequest = new Request();
        $paramStoreRequest->replace($sampleProducts[$testData['request']['current_product']]);
        $sampleProductTypeId = $testData['request']['id_product_type'];

        // store sample current product
        $currentProduct = (new RenewedProductController())->store($paramStoreRequest, $sampleProductTypeId);
        $this->assertNotEmpty($currentProduct);

        RequestGuard::macro('logout', function() {
            $this->user = null;
        });
        $this->app['auth']->logout();

        if ($testData['merchant'] != null) {
            $this->actingAs($mockMerchant);
        }

        // define update request parameters
        $paramUpdateRequest = new Request();
        $paramUpdateRequest->replace($testData['request']['product']);

        // call function
        $updatedProduct = (new ProductController())->mutantUpdate7($paramUpdateRequest, $currentProduct->id);
        if (!$expectedResult['is_error']) {
            $this->assertNotEmpty($updatedProduct);

            // define expected result
            $expectedProduct = new Product($expectedResult['product']);
            $expectedProduct->user_id = $mockMerchant->id;
            $expectedProduct->images = $expectedResult['product']['images'];
            $expectedProduct->asal = $expectedResult['product']['asal'];

            // assert value
            $this->assertEquals($expectedProduct->name, $updatedProduct->name);
            $this->assertEquals($expectedProduct->price, $updatedProduct->price);
            $this->assertEquals($expectedProduct->images, $updatedProduct->images);
            $this->assertEquals($expectedProduct->stock, $updatedProduct->stock);
            $this->assertEquals($expectedProduct->description, $updatedProduct->description);
            $this->assertEquals($expectedProduct->specification, $updatedProduct->specification);
            $this->assertEquals($expectedProduct->asal, $updatedProduct->asal);
            $this->assertEquals($expectedProduct->color, $updatedProduct->color);
            $this->assertEquals($expectedProduct->user_id, $updatedProduct->user_id);
            $this->assertEquals($expectedProduct->sold, $updatedProduct->sold);
        } else {
            $this->assertEmpty($updatedProduct);
        }
    }

    /**
     * @test
     * @dataProvider getTestCasesUpdate
     */
    public function testMutantUpdate8($testData, $expectedResult, $sampleProducts)
    {
        $dataMerchant = ['username' => 'merchant'];
        if ($testData['merchant'] != null) {
            $dataMerchant = $testData['merchant'];
        }

        // define mock data
        // mock merchant
        $mockMerchant = factory(User::class)->create($dataMerchant);
        $this->actingAs($mockMerchant);

        // define store request parameters
        $paramStoreRequest = new Request();
        $paramStoreRequest->replace($sampleProducts[$testData['request']['current_product']]);
        $sampleProductTypeId = $testData['request']['id_product_type'];

        // store sample current product
        $currentProduct = (new RenewedProductController())->store($paramStoreRequest, $sampleProductTypeId);
        $this->assertNotEmpty($currentProduct);

        RequestGuard::macro('logout', function() {
            $this->user = null;
        });
        $this->app['auth']->logout();

        if ($testData['merchant'] != null) {
            $this->actingAs($mockMerchant);
        }

        // define update request parameters
        $paramUpdateRequest = new Request();
        $paramUpdateRequest->replace($testData['request']['product']);

        // call function
        $updatedProduct = (new ProductController())->mutantUpdate8($paramUpdateRequest, $currentProduct->id);
        if (!$expectedResult['is_error']) {
            $this->assertNotEmpty($updatedProduct);

            // define expected result
            $expectedProduct = new Product($expectedResult['product']);
            $expectedProduct->user_id = $mockMerchant->id;
            $expectedProduct->images = $expectedResult['product']['images'];
            $expectedProduct->asal = $expectedResult['product']['asal'];

            // assert value
            $this->assertEquals($expectedProduct->name, $updatedProduct->name);
            $this->assertEquals($expectedProduct->price, $updatedProduct->price);
            $this->assertEquals($expectedProduct->images, $updatedProduct->images);
            $this->assertEquals($expectedProduct->stock, $updatedProduct->stock);
            $this->assertEquals($expectedProduct->description, $updatedProduct->description);
            $this->assertEquals($expectedProduct->specification, $updatedProduct->specification);
            $this->assertEquals($expectedProduct->asal, $updatedProduct->asal);
            $this->assertEquals($expectedProduct->color, $updatedProduct->color);
            $this->assertEquals($expectedProduct->user_id, $updatedProduct->user_id);
            $this->assertEquals($expectedProduct->sold, $updatedProduct->sold);
        } else {
            $this->assertEmpty($updatedProduct);
        }
    }
}
