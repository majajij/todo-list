<?php

namespace App\Http\Controllers;

use App\Models\MyList;
use Illuminate\Http\Request;

class MyListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $my_lists = MyList::paginate(3);
        return response()->json(['data' => $my_lists], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $new_list = MyList::create([
                'task' => $request->task,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['data' => ['message' => $th->getMessage()]], 400);
        }

        return response()->json(['data' => $new_lists], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MyList  $myList
     * @return \Illuminate\Http\Response
     */
    public function show(MyList $myList)
    {
        return response()->json(['data' => $myList], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MyList  $myList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MyList $myList)
    {
        try {
            $myList->update([
                'task' => $request->task,
            ]);
        } catch (\Throwable $th) {
            //TODO change class of 404
            // verify status code
            return response()->json(['data' => ['message' => $th->getStatus()]], 400);
        }

        return response()->json(['data' => $myList], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MyList  $myList
     * @return \Illuminate\Http\Response
     */
    public function destroy(MyList $myList)
    {
        try {
            $myList->delete();
        } catch (\Throwable $th) {
            //TODO change class of 404
            // verify status code
            return response()->json(['data' => ['message' => $th->getStatus()]], 400);
        }

        return response()->json(['data' => $myList], 200);
    }
}
