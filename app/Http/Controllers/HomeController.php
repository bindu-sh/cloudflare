<?php

namespace App\Http\Controllers;

use App\Helpers\CloudflareHelper\Cloudflare;
use App\Models\Cloudflare\DnsRecords;
use App\Models\Cloudflare\Domain;
use Illuminate\Http\Request;
use App\Models\Cloudflare\Account;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Account $domain)
    {


        Cloudflare::purgeCacheByFile($domain);
        $getrecords=Domain::all();
        return view('home',['domains'=>$getrecords]);
    }
    public function fetchAccounts(){
        Cloudflare::GetAccounts();
    }
    public function updateDnsRecord(){
        Cloudflare::updateDns();
    }

    public function createDns(){
        Cloudflare::createDns();
    }
    public function deleteDns(){
        Cloudflare::deleteDns();
    }
    public function deleteZones(){
        Cloudflare::deleteZones();
    }
    public function insertDNSRecords(Request $request){
        $getDNS=Cloudflare::getListDns($request->domainId);
        $insertDNSRecord=[];

        foreach($getDNS['dnsRecords'] as $key=>$dnsrecord){
            foreach($dnsrecord['result'] as $dns){

                $insertDNSRecord[]=array(
                    'zone_id'=>$dns['zone_id'],
                    'identifier'=>$dns['id'],
                    'type'=>$dns['type'],
                    'name'=>$dns['name'],
                    'content'=>$dns['content'],
                    'ttl'=>$dns['ttl'],
                    'proxy_status'=>$dns['proxied'],
                );
            }

        }
        DnsRecords::insert($insertDNSRecord);
        return true;
    }
    public function insertDomain(Account $account){
        $result=Cloudflare::getDomains($account);

        $insertArr=[];
        $insertDomain=[];
        foreach($result['result'] as $key=>$value){
            $permission=json_encode($value['permissions'],true);
            $dns=json_encode($value['name_servers'],true);
            $insertArr[]=array(
                'account_id'=>$value['account']['id'],
                'account_name'=>$value['account']['name'],
                'apiDetails'=>$permission,
                'notes'=>$dns,
            );
            $insertDomain[]=array(
                'domain'=>$value['name'],
                'zoneid'=>$value['id'],
                'status'=>$value['status']
            );
            Cloudflare::insertZoneInCloudflare($account);

        }
        domain::insert($insertDomain);
        account::insert($insertArr);
    }
}
