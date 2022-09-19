<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\User;
use App\Models\Pesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;


class TransaksiController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:index_transaksi|create_transaksi|update_transaksi|delete_transaksi', ['only' => ['index','show']]);
         $this->middleware('permission:create_transaksi', ['only' => ['create','store']]);
         $this->middleware('permission:update_transaksi', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_transaksi', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->hasRole('manager')){
            $transaksis = Transaksi::filter(request(['kasir', 'start', 'end']))->get();
        }else{
            $transaksis = Transaksi::where('user_id', \Auth::user()->id)->get();
        }
        $cashiers = [];

        foreach (User::all() as $key => $user) {
            if($user->hasRole('kasir')){
                $cashiers[] = $user;
            }
        }

        return view('transaksi.index', [
            'transaksis' => $transaksis,
            'cashiers' => $cashiers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::all();
        $mejas = Meja::where('status', 'tidak')->get();
        return view('transaksi.create', [
            'menus' => $menus,
            'mejas' => $mejas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransaksiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'menu_id' => 'required',
            'jml' => 'required',
            'meja_id' => 'required'
        ]);

        $transaksi = Transaksi::create([
            'user_id' => \Auth::user()->id,
            'total_harga' => 0,
            'meja_id' => $request->meja_id
        ]);

        $totalHargaPesanan = 0;

        foreach ($request->menu_id as $key => $menu) {
            $menuQuery = Menu::findOrFail($menu);

            Pesanan::create([
                'transaksi_id' => $transaksi->id,
                'menu_id' => $menu,
                'jml' => $request->jml[$key],
                'total_harga' => $menuQuery->harga * $request->jml[$key]
            ]);

            $totalHargaPesanan += $menuQuery->harga * $request->jml[$key];
        }

        $transaksi->update([
            'total_harga' => $totalHargaPesanan
        ]);

        return redirect('/transaksi');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        $menus = Menu::all();
        return view('transaksi.edit', [
            'menus' => $menus,
            'transaksi' => $transaksi
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransaksiRequest  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransaksiRequest $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        foreach ($transaksi->pesanan as $key => $pesanan) {
            $pesanan->delete();
        }

        $transaksi->delete();

        return redirect()->back();
    }

    public function pdf(){
        $transaksis = Transaksi::filter(request(['kasir', 'start', 'end']))->get();
        $pdf = PDF::loadView('transaksi.export', compact('transaksis'));
        
        return $pdf->download('Laporan Penjualan.pdf');
    }

    public function payment(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $pesanans = Pesanan::where('transaksi_id', $id)->get();
        
        $sume = $transaksi->total_harga;

        $apiContext = new ApiContext(
        new OAuthTokenCredential(
            'ASgBxmhL_opNloeB8cVwLO9HAJei5PBfzbA32CT-LxdR1Nd4XyrksdZIz5yGyEGvkiakJ6YX9pimZW5g',
                    'ECmTlt0qr2e-Ue-Dge_BrxRHKHQ_fg4U09-SfYZaz512s_ozvT9mHE43__0HB1jUaC5Hdh4Z0YH2V-8h'
            )
        );
        
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // Set redirect URLs
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal.success'))
            ->setCancelUrl(route('paypal.cancel'));
        // dd($redirectUrls);
        // Set payment amount
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($sume);


        // Set transaction object
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription(" Hello ");
        //   dd($transaction);
        // Create the full payment object
        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        // dd($payment);
        // Create payment with valid API context
        try {

            $payment->create($apiContext);
            // dd($payment);
            // Get PayPal redirect URL and redirect the customer
            // $approvalUrl =
            return redirect($payment->getApprovalLink());
            // dd($approvalUrl);
            // Redirect the customer to $approvalUrl
        } catch (PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }
    }


    

    public function success(Request $request)
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'ASgBxmhL_opNloeB8cVwLO9HAJei5PBfzbA32CT-LxdR1Nd4XyrksdZIz5yGyEGvkiakJ6YX9pimZW5g',
                    'ECmTlt0qr2e-Ue-Dge_BrxRHKHQ_fg4U09-SfYZaz512s_ozvT9mHE43__0HB1jUaC5Hdh4Z0YH2V-8h'

            )
        );

        // Get payment object by passing paymentId
        $paymentId = $_GET['paymentId'];
        $payment = Payment::get($paymentId, $apiContext);
        $payerId = $_GET['PayerID'];

        // Execute payment with payer ID
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            dd('success');
        } catch (PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }
    }

    public function cancel()
    {
        dd('payment cancel');
    }
}
