<?php

namespace Tests\Feature\Http\Controllers\Renewed;

use App\Http\Controllers\Renewed\TransactionController;
use App\Order;
use App\Product;
use App\Transaction;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class TransactionControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function getTestCasesUpdateStatus()
    {
        $path = __DIR__ . "/../TestCases/transactionController_updateStatus.json";
        $testCasesJSON = file_get_contents($path);
        $decodedTestCases = json_decode($testCasesJSON, true);

        $testCases = [];
        foreach ($decodedTestCases as $dtc) {
            $testName = $dtc['test_name'];
            $testData = $dtc['test_data'];
            $expectedResult = $dtc['test_expected_result'];

            // example:
            // [
            //     "success_terima" => $testData, $expectedResult,
            //     "success_tolak" => $testData, $expectedResult,
            // ]
            $testCases[$testName] = [$testData, $expectedResult];
        }

        return $testCases;
    }

    /**
     * @test
     * @dataProvider getTestCasesUpdateStatus
     */
    public function testUpdateStatus($testData, $expectedResult)
    {
        // define mock data
        // mock customer and merchant
        $mockCustomer = factory(User::class)->create($testData['customer']);
        $mockMerchant = factory(User::class)->create($testData['merchant']);
        // mock transaction
        $testData['transaction']['customer_id'] = $mockCustomer->id;
        $testData['transaction']['merchant_id'] = $mockMerchant->id;
        $mockTransaction = factory(Transaction::class)->create($testData['transaction']);
        // mock product
        $testData['product']['user_id'] = $mockMerchant->id;
        $mockProduct = factory(Product::class)->create($testData['product']);
        // mock order
        $testData['order']['product_id'] = $mockProduct->id;
        $testData['order']['transaction_id'] = $mockTransaction->id;
        factory(Order::class)->create($testData['order']);

        // define parameters
        $paramTransactionId = $mockTransaction->id;
        $paramRequest = new Request();
        $paramRequest->replace($testData['request']);

        // call function and assert value
        $updateCount = (new TransactionController())->updateStatus($paramRequest, $paramTransactionId);
        $this->assertEquals($expectedResult, $updateCount);
    }
}
