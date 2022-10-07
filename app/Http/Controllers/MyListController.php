<?php

namespace App\Http\Controllers;

use App\Models\MyList;
use Illuminate\Http\Request;
use Exception;

class MyListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $my_lists = auth()
            ->user()
            ->myLists()
            ->paginate(3);
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
                'user_id' => auth()->user()->id,
                'task' => $request->task,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['data' => ['message' => $th->getMessage()]], 400);
        }

        return response()->json(['data' => $new_list], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MyList  $myList
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $my_list = MyList::where('id', $id)
                ->where('user_id', auth()->user()->id)
                ->first();
            if (!$my_list) {
                throw new Exception('There is no List with this ID');
            }
        } catch (\Throwable $th) {
            return response()->json(['data' => ['message' => $th->getMessage()]], 400);
        }
        return response()->json(['data' => $my_list], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MyList  $myList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $my_list = MyList::where('id', $id)
                ->where('user_id', auth()->user()->id)
                ->first();
            if (!$my_list) {
                throw new Exception('Update failed, please verify the ID list');
            } else {
                $my_list->update([
                    'task' => $request->task,
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['data' => ['message' => $th->getMessage()]], 400);
        }

        return response()->json(['data' => $my_list], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MyList  $myList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $my_list = MyList::where('id', $id)
                ->where('user_id', auth()->user()->id)
                ->first();
            if (!$my_list) {
                throw new Exception('Delete failed, please verify the ID list');
            } else {
                $my_list->delete();
            }
        } catch (\Throwable $th) {
            return response()->json(['data' => ['message' => $th->getMessage()]], 400);
        }

        return response()->json(['data' => $my_list], 200);
    }
}
