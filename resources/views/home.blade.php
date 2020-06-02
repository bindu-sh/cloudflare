@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="create-table">

                        <table>
                            <thead>
                            <th></th>
                            <th>Domain Name</th>
                            <th>Status</th>
                            <th>Id</th>

                            </thead>
                            <tbody>
                            @foreach($domains as $key=>$value)
                            <tr>
                                <td><button class="btn btn-primary " id="fetchDns" doaminID="{{$value->zoneid}}" >Refetch Dns</button></td>
                                <td>{{$value->domain}}</td>
                                <td>{{$value->status}}</td>
                                <td>{{$value->zoneid}}</td>


                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous">
    </script>
    <script>
        $(document).on('click','#fetchDns',function(){
            var domainId=$(this).attr('doaminID');
            $.ajax({
                url:'insertDns',
                type:'get',
                data:{domainId:domainId},
                success:function(){

                }
            });
        });
    </script>

@endsection
