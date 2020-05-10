<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Resources\CustomerCollectionResource;
use App\Http\Resources\CustomerOrderResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ResponseResource;
use App\Order;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
    {
        return (new CustomerCollectionResource(Customer::all()))
            ->additional(['message' => 'Berhasil']);
    }

    public function show($customerId)
    {
        $customer = Customer::find($customerId);
        return (new CustomerResource($customer))->additional(['message' => 'Berhasil']);
    }

    public function store(Request $request)
    {
        $valid = $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);
        $customer = Customer::firstOrCreate($valid);
        if ($customer != null) {
            return (new ResponseResource($customer, 'Berhasil'))
                ->response()
                ->setStatusCode(201);
        }
        return (new ResponseResource(null, 'Gagal'))
            ->response()
            ->setStatusCode(400);
    }

    public function destroy($customerId)
    {
        $customer = Customer::find($customerId);
        if ($customer == null) {
            return (new ResponseResource(null, 'Customer tidak ada'))
                ->response()
                ->setStatusCode(400);;
        }
        if ($customer->delete()) {
            return (new ResponseResource($customer, 'Berhasil'))
                ->response()
                ->setStatusCode(204);
        }
        return (new ResponseResource(null, 'Gagal'))
            ->response()
            ->setStatusCode(400);;
    }
}
