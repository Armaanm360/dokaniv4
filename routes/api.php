<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* Expense Head */
Route::resource('expense-head', ExpenseHead\ExpenseHeadController::class);

Route::resource('expense-sub-head', ExpenseSubHead\ExpenseSubHeadController::class);



Route::get('search-account', function (Request $request) {
    return search_account($request->q);
});

Route::get('search-account-full-data', function (Request $request) {
    return search_account_full_data($request->q);
});



/* Money Receipt */
Route::resource('money-receipt', MoneyReceipt\MoneyReceiptController::class);
/* Money Receipt */


Route::resource('delivery-men', DeliveryMan\DeliveryManController::class);

/* expense */
Route::resource('expenses', Expenses\ExpensesController::class);

Route::resource('delivery-men', DeliveryMan\DeliveryManController::class);
Route::resource('company-info', CompanyInfo\CompanyInfoController::class);


Route::get('get-invoice-full-information', function (Request $request) {
    return get_invoice_full_information($request->q);
});




Route::resource('expense-head', ExpenseHead\ExpenseHeadController::class);
Route::resource('expense-sub-head', ExpenseSubHead\ExpenseSubHeadController::class);
Route::resource('products', Products\ProductsController::class);
Route::resource('product-category', ProductCategory\ProductCategoryController::class);
Route::resource('warehouse', Warehouse\WarehouseController::class);
Route::resource('attributes', Attribute\AttributeController::class);
Route::resource('attribute-values', AttributeValues\AttributeValuesController::class);
Route::resource('branch', Branch\BranchController::class);
Route::resource('terms', Terms\TermsController::class);
Route::resource('staff', Staff\StaffController::class);


Route::resource('suppliers', Suppliers\SuppliersController::class);

Route::resource('expenses', Expenses\ExpensesController::class);


Route::resource('accounts', Accounts\AccountsController::class);


Route::post('account/save-opening-balance', 'AccountTransactions\AccountTransactionsController@save_opening_balance');


Route::resource('account-transfer', Accounts\AccountTransferController::class);

Route::get('account/balance-statement', 'Accounts\AccountsController@balance_statement');


Route::get('account/account-statement/{any}', 'Accounts\AccountsController@account_statement');


Route::post('account/save-non-invoice-income', 'Accounts\AccountsController@save_non_invoice_income');


//Purchase 
Route::resource('purchases', Purchases\PurchasesController::class);

//warehouse to branch

Route::resource('warehouse-branch-transfer', Transfer\WarehouseToBranchTransferController::class);


//inventory

Route::post('inventory-check', 'Inventory\InventoryController@inventoryCheck');


//invoice pos sale
Route::resource('invoice', Invoice\InvoiceController::class);



//registration

Route::post('registration', 'Admin\UserRegistrationController@userRegisterController');

Route::post('new-login', 'Admin\UserRegistrationController@userLoginController');

//warehouse
Route::get('get-purchased-product-list-api/{warehouse_id}', 'Purchases\PurchasesController@purchasedProductsApi');


//clients
Route::resource('client', Client\ClientController::class);




//Reports Controller Individual


Route::get('datewise-transfer', 'AllReports\DateWiseController@dateWiseReport');


Route::get('datewise-sell', 'AllReports\DateWiseSellController@dateWiseReport');


Route::get('datewise-purchase', 'AllReports\DateWisePurchaseController@dateWiseReport');

Route::get('datewise-supplier-purchase', 'AllReports\SupplierWisePurchaseController@supplierWiseReport');




Route::get('datewise-profit-loss', 'AllReports\ProfitLossController@getProfitLossDatewise');
