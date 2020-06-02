<?php

namespace App\Http\Controllers;

use App\dnsRecords;
use Illuminate\Http\Request;

class CloudflareRecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\dnsRecords  $cloudflare_records
     * @return \Illuminate\Http\Response
     */
    public function show(dnsRecords $cloudflare_records)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\dnsRecords  $cloudflare_records
     * @return \Illuminate\Http\Response
     */
    public function edit(dnsRecords $cloudflare_records)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\dnsRecords  $cloudflare_records
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, dnsRecords $cloudflare_records)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\dnsRecords  $cloudflare_records
     * @return \Illuminate\Http\Response
     */
    public function destroy(dnsRecords $cloudflare_records)
    {
        //
    }
}
