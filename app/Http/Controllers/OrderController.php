<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\OrderList;
use App\Models\Task;
use App\Models\Invoice;

class OrderController extends Controller
{


public function NewOrderForm()
{
    $orderList = OrderList::where('user_id', Auth::id())
        ->whereNull('order_id')
        ->get();

    return view('user.dashboard.order.new', compact('orderList'));
}

public function DisplayAllOrders()
{
    $orders = Auth::user()->Orders()
        ->with('OrderList')
        ->where('is_archived', false)
        ->where('is_canceled', false)
        ->get();

    return view('user.dashboard.order.index', compact('orders'));
}

// FIX: صفحة مخصصة للطلبات الملغية
public function DisplayCancelledOrders()
{
    $orders = Auth::user()->Orders()
        ->with('OrderList')
        ->where('is_canceled', true)
        ->get();

    return view('user.dashboard.order.cancelled', compact('orders'));
}

public function DisplayOrder(Order $order)
{

    if ($order->client_id !== Auth::id()) {
        abort(403);
    }

    $tasks = $order->Tasks;
    $orderList = $order->OrderList;

    $taskGroups = [];

    foreach($tasks as $item){
        if(!in_array($item->group, $taskGroups)){
            $taskGroups[] = $item->group;
        }
    }

    return view('user.dashboard.order.show', compact('order','tasks','taskGroups','orderList'));
}

public function CancelOrder(Order $order)
{

    if ($order->client_id !== Auth::id()) {
        abort(403);
    }

    $order->is_canceled = true;
    $order->is_archived = true;
    $order->save();

    return redirect()->route('displayAllOrders');
}

public function DisplayInvoice(Order $order)
{

    if ($order->client_id !== Auth::id()) {
        abort(403);
    }

    $user = Auth::user();
    $invoice = $order->Invoice()->first();
    $tasks = $order->Tasks;
    $orderList = $order->OrderList;

    return view('user.dashboard.invoice', compact('user','order','tasks','invoice','orderList'));
}



public function AddProductToList($category, $id)
{
    $user = Auth::user();

    if(!$user){
        return redirect()->route('loginForm');
    }

    $map = [
        "hardwares" => "hardware",
        "softwares" => "software",
        "services"  => "service",
        "courses"   => "course",
    ];

    $prodCategory = $map[$category] ?? $category;

    // FIX: منع تكرار نفس المنتج فالسلة
    $alreadyExists = OrderList::where('user_id', $user->id)
        ->whereNull('order_id')
        ->where('prod_id', $id)
        ->where('prod_category', $prodCategory)
        ->exists();

    if ($alreadyExists) {
        return redirect()->back()->with('info', 'هذا المنتج موجود أصلاً في السلة');
    }

    $item = new OrderList();
    $item->user_id       = $user->id;
    $item->prod_category = $prodCategory;
    $item->prod_id       = $id;
    $item->volume        = request()->volume ?? 1;
    $item->order_id      = null;
    $item->save();

    return redirect()->back()->with('success', 'Produit ajouté');
}

public function RemoveProductFromList(OrderList $listItem)
{
    // FIX: تحقق أن هذا الـ item ديال المستخدم الحالي
    if ($listItem->user_id !== Auth::id()) {
        abort(403, 'غير مصرح لك بهذا الإجراء');
    }

    $listItem->delete();
    return redirect()->back();
}



public function store(Request $request)
{
    $user = Auth::user();

    // FIX: تحقق أن السلة مو خاوية
    $hasItems = OrderList::where('user_id', $user->id)
        ->whereNull('order_id')
        ->exists();

    if (!$hasItems) {
        return redirect()->back()->withErrors(['cart' => 'لا يمكن إنشاء طلب بسلة فارغة']);
    }

    $order = new Order();
    $order->title        = $request->title;
    $order->description  = $request->description;
    $order->client_id    = $user->id;
    $order->order_status = 'pending';
    $order->save();

    OrderList::where('user_id', $user->id)
        ->whereNull('order_id')
        ->update(['order_id' => $order->id]);

    return redirect()->route('displayAllOrders');
}



public function IndexPendingOrders(Request $request)
{
    $searching = false;
    $isFound   = false;

    $query = Order::with(['OrderList', 'Client'])
        ->where('is_archived', false)
        ->where('order_status', 'pending');

    if($request->search){
        $searching = true;
        $query->where(function ($q) use ($request){
            $q->where('title', 'LIKE', '%' . $request->search . '%')
              ->orWhere('client_id', 'LIKE', '%' . $request->search . '%');
        });
    }

    $orders  = $query->paginate(15);
    $isFound = $orders->isNotEmpty();

    return view('admin.order.index-pending', compact('orders','searching','isFound'));
}

public function IndexDeliveringOrders(Request $request)
{
    $searching = false;
    $isFound   = false;

    $query = Order::with(['OrderList', 'Client'])
        ->where('is_archived', false)
        ->where('order_status', 'delivering');

    if($request->search){
        $searching = true;
        $query->where(function ($q) use ($request){
            $q->where('title', 'LIKE', '%' . $request->search . '%')
              ->orWhere('client_id', 'LIKE', '%' . $request->search . '%');
        });
    }

    $orders  = $query->paginate(15);
    $isFound = $orders->isNotEmpty();

    return view('admin.order.index-delivering', compact('orders','searching','isFound'));
}

public function IndexCompletedOrders(Request $request)
{
    $searching = false;
    $isFound   = false;

    $query = Order::with(['OrderList', 'Client'])
        ->where('is_archived', false)
        ->where('order_status', 'completed');

    if($request->search){
        $searching = true;
        $query->where(function ($q) use ($request){
            $q->where('title', 'LIKE', '%' . $request->search . '%')
              ->orWhere('client_id', 'LIKE', '%' . $request->search . '%');
        });
    }

    $orders  = $query->paginate(15);
    $isFound = $orders->isNotEmpty();

    return view('admin.order.index-completed', compact('orders','searching','isFound'));
}

public function IndexArchivedOrders(Request $request)
{
    $searching = false;
    $isFound   = false;

    $query = Order::with(['OrderList', 'Client'])
        ->where('is_archived', true);

    if($request->search){
        $searching = true;
        $query->where(function ($q) use ($request){
            $q->where('title', 'LIKE', '%' . $request->search . '%')
              ->orWhere('client_id', 'LIKE', '%' . $request->search . '%');
        });
    }

    $orders  = $query->paginate(15);
    $isFound = $orders->isNotEmpty();

    return view('admin.order.index-archived', compact('orders','searching','isFound'));
}

public function ShowOrder(Order $order)
{
    $client    = $order->Client;
    $orderList = $order->OrderList;
    $tasks     = $order->Tasks;

    $taskGroups = [];

    foreach($tasks as $item){
        if(!in_array($item->group, $taskGroups)){
            $taskGroups[] = $item->group;
        }
    }

    return view('admin.order.show', compact(
        'order','tasks','client','taskGroups','orderList'
    ));
}

public function changeOrderStatus(Order $order)
{
    // FIX: منع تغيير status ديال طلب ملغي أو مأرشف
    if ($order->is_canceled || $order->is_archived) {
        return redirect()->back()->withErrors(['status' => 'لا يمكن تغيير حالة طلب ملغي أو مأرشف']);
    }

    $statusFlow = [
        'pending'    => 'delivering',
        'delivering' => 'completed',
        'completed'  => 'completed',
    ];

    $current = $order->order_status;
    $order->order_status = $statusFlow[$current] ?? $current;
    $order->save();

    return redirect()->back()->with('success', 'Status updated');
}


public function ArchiveOrder(Order $order)
{
    $order->is_archived = true;
    $order->save();

    return redirect()->route('indexCompletedOrders')->with('success', 'Order archived');
}


public function UnarchiveOrder(Order $order)
{
    $order->is_archived = false;
    $order->save();

    return redirect()->route('indexArchivedOrders')->with('success', 'Order unarchived');
}


public function AddTask(Request $request, Order $order)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'group' => 'required|string|max:255',
        'cost'  => 'required|numeric',
    ]);

    Task::create([
        'order_id' => $order->id,
        'title'    => $request->title,
        'group'    => $request->group,
        'cost'     => $request->cost,
        'is_done'  => false,
    ]);

    return redirect()->back()->with('success', 'Task added');
}


public function EditTask(Request $request, Order $order, Task $task)
{
    $request->validate([
        'title'   => 'required|string|max:255',
        'group'   => 'required|string|max:255',
        'cost'    => 'required|numeric',
        'is_done' => 'boolean',
    ]);

    $task->title   = $request->title;
    $task->group   = $request->group;
    $task->cost    = $request->cost;
    $task->is_done = $request->is_done ?? false;
    $task->save();

   
    $totalCost = $order->Tasks()->sum('cost');
    $invoice   = $order->Invoice()->first();

    if($invoice){
        $invoice->total_price = $totalCost;
        $invoice->save();
    }

    return redirect()->back()->with('success', 'Task updated');
}

}