<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use Redirect;
use App\Imports\ItemsImport;
use App\Imports\FirstSheetImport;
use App\Exports\ItemsExport;
use App\Exports\ItemTableExport;
use App\Exports\CustomerExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Yajra\Datatables\Datatables;
use App\Rules\ItemRule;
use Maatwebsite\Excel\Concerns\WithStyles; 
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ItemController extends Controller
{
    public function index()
    {
        // $items = Item::paginate(10);
        // $items = Item::orderBy('item_id','desc')->paginate(5);
        // $items = Item::orderBy('item_id','desc')
        // return view('item.index',compact('items'));
        // return Datatables::of($items)->make();
        return view('item.index');
    }
    public function getItem(){
        // $items = Item::select('item_id','description','sell_price','cost_price');
        // ->orderBy('item_id','desc');
        // $items = Item::with('item')->get();
        $items = Item::all();
        // dd($items);
        return Datatables::of($items)->make(true);
    }
    public function create()
    {
        return view('item.create');
    }
    public function store(Request $request)
    {
        $file = $request->file('img_path');
        $name = $file->getClientOriginalName();
        $request->img_path = $name;
        $file->move(public_path('/images'), $name);
        $input = $request->all();
        $input['img_path'] = $name;
        Item::create($input);
     return Redirect::to('item')->with('success', 'Information has been added');;
    }
    public function show($id)
    {
        $item = Item::find($id);
        return view('item.show',compact('item'));
    }
    public function edit($id)
    {
        $item = Item::find($id);
        return view('item.edit',compact('item'));
    }
    public function update(Request $request, $id)
    {
       $item= Item::find($id);
        $item->description=$request->get('description');
        $item->sell_price=$request->get('sell_price');
        $item->cost_price=$request->get('cost_price');
        $item->save();
        return redirect('item');
    }
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();
        return redirect('item')->with('success','Information has been  deleted');
    }
    public function import(Request $request) {
         $request->validate([
        'item_upload' => ['required', new ItemRule($request->file('item_upload'))],
    ]);
        Excel::import(new ItemsImport, request()->file('item_upload')->store('temp'));
        // Excel::import(new FirstSheetImport, request()->file('item_upload')->store('temp'));
        return redirect()->back()->with('success', 'Excel file Imported Successfully');
    }
    public function export() 
    {
        // return Excel::download(new ItemsExport, 'item.xlsx');
         // return Excel::download(new ItemTableExport, 'item-table.excel');
        // return Excel::download(new CustomerExport, 'customer-table.pdf', 
        return Excel::download(new ItemTableExport, 'item-table_'.now().'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}