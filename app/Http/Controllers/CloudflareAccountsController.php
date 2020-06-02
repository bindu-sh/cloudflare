<?php

namespace App\Http\Controllers;

use App\account;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CloudflareAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\account  $cloudflare_accounts
     * @return \Illuminate\Http\Response
     */
    public function show(account $cloudflare_accounts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\account  $cloudflare_accounts
     * @return \Illuminate\Http\Response
     */
    public function edit(account $cloudflare_accounts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\account  $cloudflare_accounts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, account $cloudflare_accounts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\account  $cloudflare_accounts
     * @return \Illuminate\Http\Response
     */
    public function destroy(account $cloudflare_accounts)
    {
        //
    }
}
