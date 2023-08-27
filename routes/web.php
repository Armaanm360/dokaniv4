<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\BarcodeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/test-invoice', 'HomeController@testInvoice')->name('home');

Route::get('/today-invoices', 'Invoice\InvoiceController@today_invoices')->name('home');

/* users */

Route::resource('users', Admin\UserController::class)->middleware('auth');

/* Role */

Route::resource('roles', Admin\RoleController::class)->middleware('auth');

/* Permission */

Route::resource('permissions', Admin\PermissionController::class)->middleware('auth');


Route::resource('invoice', Invoice\InvoiceController::class)->middleware('auth');
Route::resource('invoice-return', InvoiceReturn\invoiceReturnController::class)->middleware('auth');
Route::get('invoice-return-sale/{sale_id}', 'InvoiceReturn\invoiceReturnController@invoiceReturnSale')->middleware('auth');
Route::get('invoice-return-account/{account_info}', 'InvoiceReturn\invoiceReturnController@getAccountInfo')->middleware('auth');


Route::get('invoice/get-delivery-vehicle/{id}', 'Invoice\InvoiceController@getDeliveryVehicle')->middleware('auth');
Route::get('invoice/account-type/{account_type}', 'Invoice\InvoiceController@paymentType')->middleware('auth');
//Route::get('invoice/return/{sale_id}', 'invoice\invoiceController@invoiceReturn')->middleware('auth');

Route::resource('cashbook', Cashbook\CashbookController::class)->middleware('auth');
Route::resource('client', Client\ClientController::class)->middleware('auth');
Route::get('online-client-list', 'Client\ClientController@onlineClient');
Route::get('wholesale-client-list', 'Client\ClientController@wholesaleClient');
Route::resource('expenses', Expenses\ExpensesController::class)->middleware('auth');
Route::resource('inventory', Inventory\InventoryController::class)->middleware('auth');
Route::post('inventory-list', 'Inventory\InventoryController@list')->middleware('auth');
Route::resource('products', Products\ProductsController::class)->middleware('auth');
Route::get('search-product-ssk', 'Products\ProductsController@productSearch')->middleware('auth');
Route::resource('purchases', Purchases\PurchasesController::class)->middleware('auth');
Route::get('get-purchase-id/{id}', 'Purchases\PurchasesController@purchaseId');
Route::get('get-purchased-product-list', 'Purchases\PurchasesController@purchasedProducts');
//Route::resource('receive-money', ReceiveMoney\ReceiveMoneyController::class)->middleware('auth');

Route::resource('purchase-return', PurchaseReturn\PurchaseReturnController::class)->middleware('auth');
Route::get('get-product-barcode/{id}', 'Products\ProductsController@get_product_barcode');
Route::get('scan-barcode', 'Products\ProductsController@barcode_scan');
Route::get('get-supplier-id/{id}', 'PurchaseReturn\PurchaseReturnController@getPurchaseNumber');
Route::post('get-purchase-data', 'PurchaseReturn\PurchaseReturnController@getPurchaseData');
Route::resource('receive-money', ReceiveMoney\ReceiveMoneyController::class)->middleware('auth');

Route::resource('report', Report\ReportController::class)->middleware('auth');
Route::resource('suppliers', Suppliers\SuppliersController::class)->middleware('auth');
Route::get('search-supplier', 'Suppliers\SuppliersController@supplierSearch')->middleware('auth');
Route::resource('transfer', Transfer\TransferController::class)->middleware('auth');
Route::get('transfer/getToWareHouse/{id}', 'Transfer\TransferController@justWareHouse')->middleware('auth');
Route::resource('warehouse', Warehouse\WarehouseController::class)->middleware('auth');
Route::get('search-warehouse', 'Warehouse\WarehouseController@warehouseSearch')->middleware('auth');
Route::resource('branch', Branch\BranchController::class)->middleware('auth');
Route::get('search-branch', 'Branch\BranchController@branchSearch')->middleware('auth');
Route::resource('product-category', ProductCategory\ProductCategoryController::class)->middleware('auth');
Route::resource('product-color', ProductColor\ProductColorController::class)->middleware('auth');
Route::resource('attributes', Attribute\AttributeController::class)->middleware('auth');
Route::resource('attribute-values', AttributeValues\AttributeValuesController::class)->middleware('auth');
Route::resource('staff', Staff\StaffController::class)->middleware('auth');
Route::get('staff-pdf/{id}', 'Staff\StaffController@staffPdf')->middleware('auth');



Route::resource('delivery-men', DeliveryMan\DeliveryManController::class)->middleware('auth');
Route::resource('delivery-vehicles', DeliveryVehicle\DeliveryVehicleController::class)->middleware('auth');
Route::resource('company-info', CompanyInfo\CompanyInfoController::class)->middleware('auth');
Route::resource('terms', Terms\TermsController::class)->middleware('auth');

Route::resource('warehouse-branch-transfer', Transfer\WarehouseToBranchTransferController::class)->middleware('auth');

Route::get('report/date-wise-transfers-report', 'Report\DateWiseTransferReportController@indexPage');

/* Expense Head */

Route::resource('expense-head', ExpenseHead\ExpenseHeadController::class)->middleware('auth');


Route::resource('supplier-payment', SupplierPayment\SupplierPayment::class)->middleware('auth');

/* Expense Sub Head */

Route::resource('expense-sub-head', ExpenseSubHead\ExpenseSubHeadController::class)->middleware('auth');



Route::get('search-expense-head', function (Request $request) {
    return search_agent($request->q);
});
/* Cashbook */

Route::resource('accounts', Accounts\AccountsController::class)->middleware('auth');
Route::get('account/create-opening-balance', 'Accounts\AccountsController@create_opening_balance')->middleware('auth');
Route::get('account/balance-statement', 'Accounts\AccountsController@balance_statement')->middleware('auth');
Route::get('account/account-statement/{any}', 'Accounts\AccountsController@account_statement')->middleware('auth');
Route::get('account/non-invoice-income', 'Accounts\AccountsController@non_invoice_income')->middleware('auth');
Route::post('account/save-non-invoice-income', 'Accounts\AccountsController@save_non_invoice_income')->middleware('auth');
Route::post('account/save-opening-balance', 'AccountTransactions\AccountTransactionsController@save_opening_balance')->middleware('auth');
Route::resource('account-transfer', Accounts\AccountTransferController::class)->middleware('auth');
Route::get('search-account', function (Request $request) {
    return search_account($request->q);
})->middleware('auth');
Route::get('search-account-full-data', function (Request $request) {
    return search_account_full_data($request->q);
})->middleware('auth');

/* Cashbook */

/* Money Receipt */
Route::resource('money-receipt', MoneyReceipt\MoneyReceiptController::class)->middleware('auth');
/* Money Receipt */
Route::get('barcode', 'BarcodeController@index')->name('barcode.index')->middleware('auth');
Route::get('get-sub-head/{headid}', 'Common\CommonController@getSubHead')->middleware('auth');
Route::get('pdf-create', 'Pdf\PdfController@create');



Route::get('transfer/fromwarehouse/{warehouse_id}', 'Transfer\TransferController@fromWareHouse')->middleware('auth');


/* CommonController */


Route::get(
    'search-account-trans',
    function (Request $request) {
        return search_account_trans($request->q);
    }
);



Route::get(
    'search-warehouse-product',
    function (Request $request) {
        return searchProduct($request->q);
    }
);

Route::get(
    'search-delivery-man',
    function (Request $request) {
        return searchDeliveryMan($request->q);
    }
);


Route::get(
    'search-purchased-product',
    function (Request $request) {
        return search_purchased_product($request->q);
    }
);

Route::get(
    'search-product',
    function (Request $request) {
        return search_product($request->q);
    }
);

Route::get(
    'search-supplier',
    function (Request $request) {
        return search_supplier($request->q);
    }
);
Route::get(
    'search_supplier_info',
    function (Request $request) {
        return search_supplier_info($request->q);
    }
);

// warehouse
Route::get(
    'search-warehouse',
    function (Request $request) {
        return searchWarehouse($request->q);
    }
);


// brnach
Route::get(
    'branch-name-search',
    function (Request $request) {
        return BranchNameSearch($request->q);
    }
);


// staff
Route::get(
    'search-staff',
    function (Request $request) {
        return searchStaff($request->q);
    }
);


// Client
Route::get(
    'search-client',
    function (Request $request) {
        return searchClient($request->q);
    }
);


// Datewise total Sales Report

Route::get('view-report/date-wise-sales', 'Reports\SalesReport\DateWiseTotalSalesController@index');
Route::post('view-report/get-date-wise-sales-report', 'Reports\SalesReport\DateWiseTotalSalesController@datewiseReport');
Route::get(
    'money-receipt-search-client',
    function (Request $request) {
        return searchMoneyReceiptClient($request->q);
    }
);



Route::get(
    'search-client-wise-invoice',
    function (Request $request) {
        return search_client_wise_invoice($request->q);
    }
);

Route::get('get-invoice-full-information', function (Request $request) {
    return get_invoice_full_information($request->q);
});


// Datewise total Sales Report

Route::get('reports/date-wise-sales', 'Reports\SalesReport\DateWiseSalesController@index');
Route::post('report/get-date-wise-sales-report', 'Reports\SalesReport\DateWiseSalesController@datewiseReport');


Route::get('reports/profit-loss', 'Reports\ProfitLoss\ProfitLossController@index');
Route::post('reports/get-profit-loss', 'Reports\ProfitLoss\ProfitLossController@get_profit_loss');


// Datewise transfer Report

Route::get('reports/date-wise-transfer', 'Reports\DateWiseTransferReport\DateWiseTransferReportController@index');
Route::post('reports/get-datewise-transfer-report', 'Reports\DateWiseTransferReport\DateWiseTransferReportController@transferReport');

// Datewise purchase Report

Route::get('reports/date-wise-purchase', 'Reports\PurchaseReport\DateWisePurchaseController@index');
Route::post('reports/get-datewise-purchase-report', 'Reports\PurchaseReport\DateWisePurchaseController@purchaseReport');

// Client Ledger

Route::get('reports/date-wise-client-ledger', 'Reports\ClientLedger\ClientLedgerController@index');
Route::post('reports/get-datewise-client-ledger-report', 'Reports\ClientLedger\ClientLedgerController@clientLedgerReport');

// Supplier Ledger

Route::get('reports/date-wise-supplier-ledger', 'Reports\SupplierLedger\SupplierLedgerController@index');
Route::post('reports/get-datewise-supplier-ledger-report', 'Reports\SupplierLedger\SupplierLedgerController@supplierLedgerReport');


Route::post('new-login', 'Admin\UserRegistrationController@userLoginController');

Route::post('registration', 'Admin\UserRegistrationController@userRegisterController');
