<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\FoodRecord;
use App\Models\Food;
use App\Models\User;

class FoodRecordController extends Controller
{
    /**
     * 
     * 一覧表示
     */
    public function index()
    {
        $foodRecords = FoodRecord::all();

        return view('food-record.index',compact('foodRecords'));
    }

    /**
     * 
     * 食材データ入力画面表示
     */
    public function viewCreate()
    {
        return view('food-record.create');
    }

        /**
     * Request $request
     * 
     * 新規登録
     */
    public function store(Request $request)
    {
        $rules = [];
        
        for ($i = 0; $i < 50; $i++) {
            $rules["ingredient-$i"] = "string|max:30|nullable";
            $rules["ideal-amount-$i"] = "string|max:30|nullable";
            $rules["real-amount-$i"] = "integer|max:5|nullable";
            $rules["waste-amount-$i"] = "integer|max:5|nullable";
        }

        $this->validate($request, $rules);


        // Food::create([
        //     'name' => $request->name,
        //     'read' => $request->read,
        //     'text' => $request->text,
        // ]);

        // // 上のやり方でダメな時は(tableが見つからないなどのエラーが出る)
        // $food = new Food();
        // $food->name = $request->name;
        // $food->read = $request->read;
        // $food->type = $request->type;
        // $food->text = $request->text;
        // $food->save();

        TODO:
        $record = new FoodRecord([

        ]);


        // 続けて入力するか確認するためのJavaScriptで設定した値を判定
        if ($request->input('continue_input') == 1) {
            return redirect('/create-food');
        } else {
            return redirect('/index-foods');
        }
    }

        /**
     * Request $request
     * 
     * 食材編集
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:30',
                Rule::unique('foods')->ignore($request->id),
            ],
            'read' => 'nullable|string|max:30',
            'type' => 'required|string',
            'text' => 'nullable|string|max:100',
        ]);

        $food = Food::where('id', $id)->first();
        $food->update([
            'name' => $request->name,
            'read' => $request->read,
            'type' => $request->type,
            'text' => $request->text,
        ]);

        return redirect()->to('/index-foods');
    }

    /**
     * Request $request
     * 
     * 削除
     */
    public function destroy($id)
    {
        $food = Food::find($id);
        $food->delete();
        return redirect('index-foods');
    }


}
