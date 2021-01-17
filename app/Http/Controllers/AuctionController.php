<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    private $auction;

    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    public function index(Request $request)
    {
        if($request->get('page')) {
            $auction = $this->auction->paginate($request->get('page'));
        } else {
            $auction = $this->auction->all();
        }
        return $this->onSuccess('Lelang', $auction, 'Ditemukan');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $auction = $this->auction->create($request->all());
            return $this->onSuccess('Lelang', $auction, 'Ditambahkan');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function show($id)
    {
        $auction = $this->auction->find($id);
        return $this->onSuccess('Lelang', $auction, 'Ditemukan');
    }

    public function edit(Auction $auction)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $auction = $this->auction->where('id', $id)->update($request->all());
            $auction_data = $this->auction->find($id);
            return $this->onSuccess('Lelang', $auction_data, 'Diupdate');
        } catch (\Exception $e) {
            return $this->onError($e);
        }
    }

    public function destroy($id)
    {
        $auction_data = $this->auction->find($id);
        $auction = $this->auction->destroy($id);
        return $this->onSuccess('Lelang', $auction_data, 'Dihapus');
    }
}
