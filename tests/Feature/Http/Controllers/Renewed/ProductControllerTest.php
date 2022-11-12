<?php

namespace Tests\Feature\Http\Controllers\Renewed;

use App\Http\Controllers\Renewed\ProductController;
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
    public function testStore($testData, $expectedResult)
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
        $storedProduct = (new ProductController())->store($paramRequest, $paramId);
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
    public function testUpdate($testData, $expectedResult, $sampleProducts)
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
        $currentProduct = (new ProductController())->store($paramStoreRequest, $sampleProductTypeId);
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
        $updatedProduct = (new ProductController())->update($paramUpdateRequest, $currentProduct->id);
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
