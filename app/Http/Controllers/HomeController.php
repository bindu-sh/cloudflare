<?php

namespace App\Http\Controllers;

use App\Helpers\CloudflareHelper\Cloudflare;
use App\Models\Cloudflare\DnsRecords;
use App\Models\Cloudflare\Domain;
use Illuminate\Foundation\Auth\User;
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
     * @param Domain $domain
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Domain $domain){

        $getrecords=Domain::all();
        return view('home',['domains'=>$getrecords]);
    }
    public function fetchDomains(Request $request){
        if(!empty($request->account_id)){
            $accountid=$request->account_id;
        }else{
            $accountid="f0a1146d97c497a0ffc72142eb9388b2";
        }
        $account=Account::where(['account_id'=>$accountid])->first();
        Cloudflare::getDomains($account);
    }
    public function updateDnsRecord(Request $request){
        if(!empty($request->domain_id)){
            $domain_id=$request->domain_id;
        }else{
            $domain_id="cfa9c011d0c331c7a241b4c235ed8b79";
            $dnsid='66e93d33065701190bbe64723fd7094a';
        }
        $Domain=Domain::where(['zoneid'=>$domain_id])->first();
        Cloudflare::updateDns($Domain,$dnsid);
    }

    public function createDns(Request $request){
        if(!empty($request->account_id)){
            $accountid=$request->account_id;
        }else{
            $accountid="f0a1146d97c497a0ffc72142eb9388b2";
        }
        $account=Account::where(['account_id'=>$accountid])->first();
        $data=[
            "type"=>"A",
            "name"=>"testbin.com",
            "content"=>"127.0.0.1",
            "ttl"=>120,
            "priority"=>10,
            "proxied"=>false
        ];
        Cloudflare::createDns($account,$data);
    }
    public function deleteDns(Request $request){
        if(!empty($request->domain_id)){
            $domain_id=$request->domain_id;
        }else{
            $domain_id="cfa9c011d0c331c7a241b4c235ed8b79";
        }
        Cloudflare::deleteDns($domain_id);
    }
    public function deleteZones(Request $request){
        if(!empty($request->domain_id)){
            $domainid=$request->domain_id;
        }else{
            $domainid='4245e0a32d0b9da30b5f9cf63c61aa94';
        }
        $domain=Domain::where(['zoneid'=>$domainid])->first();
        Cloudflare::deleteZones($domain);
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
    public function insertDomain(Request $request){
        if(!empty($request->account_id)){
            $accountid=$request->account_id;
        }else{
            $accountid="f0a1146d97c497a0ffc72142eb9388b2";
        }
        $account=Account::where(['account_id'=>$accountid])->first();
        $result=Cloudflare::getDomains($account);
        $insertArr=[];
        $insertDomain=[];
        foreach($result['result'] as $key=>$value){
            $permission=json_encode($value['permissions'],true);
            $dns=json_encode($value['name_servers'],true);

            $insertDomain[]=array(
                'domain'=>$value['name'],
                'zoneid'=>$value['id'],
                'status'=>$value['status']
            );
            Cloudflare::insertZoneInCloudflare($account);

        }
        domain::insert($insertDomain);

    }
    public function getDNSList(Request $request){
        if(!empty($request->account_id)){
            $accountid=$request->account_id;
        }else{
            $accountid="f0a1146d97c497a0ffc72142eb9388b2";
        }
        $account=Account::where(['account_id'=>$accountid])->first();

        $dnsRecords=Cloudflare::getDnsList($account);
       return ['dns_records'=>$dnsRecords];
    }
    public function purgeCacheForAll(Request $request){
        if(!empty($request->domain_id)){
            $domainid=$request->domain_id;
        }else{
            $domainid='4245e0a32d0b9da30b5f9cf63c61aa94';
        }
        $domain=Domain::Where(['zoneid'=>$domainid])->first();
        Cloudflare::purgeCacheForAll($domain);
    }
}
