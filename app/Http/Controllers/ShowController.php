<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Configuration;

class ShowController extends Controller
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
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request, $page) {

        $this->loadData();

        $q = $request->input('query');

        // Get page size from configurations
        $pageSize = Configuration::where('key', 'page_size')->get();
        $pageSize = $pageSize[0]->value;
        // get reference to tvmaze json file
        $content = Storage::get('tvmaze.json');
        $data = json_decode($content, true);
        $collection = collect($data);
        
        if($request->has('query') && $request->input('query') !== null) {
            $collection = $collection->where("name","LIKE", "$q");
        }
        
        $data = $collection->forPage((int)$page, (int)$pageSize)->values();
        return $data;
    
    }

    public function loadData() {

   
        if(Storage::exists('tvmaze.json')) {

            // get te last modified date for the file
            $time = Storage::lastModified('tvmaze.json');
            $today = date('Y-m-d');
            $fileDate = gmdate("Y-m-d", $time);

            // Since the tvmaze file is cached for 24 hours, therefore
            // Only download file if it is expired
            if($today !== $fileDate) {
                $this->downloadFile();
            }
        }
        else {
            $this->downloadFile();
        }

    }

    public function downloadFile() {

        // download the file from tvmaze
        // and cache it so that we dont have to face any
        // existing limititation for the api 
        $client = new \GuzzleHttp\Client();
        $res = $client->get('http://api.tvmaze.com/schedule/full');
        Storage::put('tvmaze.json', $res->getBody());

    }
}
