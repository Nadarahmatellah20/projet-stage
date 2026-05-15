<head>
    <link rel="stylesheet" href="{{ URL::asset('style/showOrderAdm.css') }}">
    <style>
        .prod-list-t td img { height: 60px; width: 60px; object-fit: cover; border-radius: 4px; }
        .prod-list-t, .prod-list-t th, .prod-list-t td { padding: 10px; border-collapse: collapse; }
        .prod-list-t thead tr { border-bottom: 10px solid var(--bg); }
        .prod-list-t tr { background-color: rgb(231,231,231); border-bottom: 3px solid var(--bg); border-radius: 10px; }
        .prod-list td a.btn { color: white; background-color: rgb(78,145,233); padding: 10px; border-radius: 2px; text-decoration: none; }
        td.option { text-align: center; }
        .invoice-form { background: #f0f8ff; border: 1px solid #cce; padding: 20px; border-radius: 8px; margin-top: 30px; }
        .invoice-form input[type=number] { padding: 6px; margin: 5px; border: 1px solid #ccc; border-radius: 4px; }
        .invoice-form button { background: #2d6ac4; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>

@extends('admin.layouts.main')
@section('main-content')

<div id="order-container">

    <h1 id="order-name">Commande N° {{ $order->id }}: {{ $order->title }}</h1>

    <h2 id="order-client">
        Par le Client:
        {{ $client ? $client->fname.' '.$client->lname : 'Client inconnu' }}
    </h2>

    <p class="created_at">{{ $order->created_at }}</p>

    <div>
        Statut:
        <span>
            @switch($order->order_status)
                @case('pending')    En Attente   @break
                @case('delivering') En Livraison @break
                @case('completed')  Complété     @break
                @default            {{ $order->order_status }}
            @endswitch
        </span>
    </div>

    <p>État d'avancement:
        @switch($order->order_status)
            @case('pending')    0%   @break
            @case('delivering') 50%  @break
            @case('completed')  100% @break
        @endswitch
    </p>

    <br>
    <div class="desc">{!! $order->description !!}</div>
    <br>

    <h2>Tâches</h2>

    <form action="{{ route('addTask', $order) }}" method="POST">
        @csrf
        <input type="text"   name="title" placeholder="Tâche titre" required>
        <input type="text"   name="group" placeholder="Tâche groupe" required>
        <input type="number" name="cost"  placeholder="Tâche coût" step="0.01" required>
        <input type="submit" value="Ajouter">
    </form>

    @foreach ($taskGroups as $group)
        <h4>{{ $group }}</h4>
        @foreach ($tasks as $task)
            @if ($task->group == $group)
                {{-- ✅ FIX: الفورم يبعث title, group, cost, is_done كلهم --}}
                <form style="display:flex; align-items:center; gap:10px;"
                      action="{{ route('editTask', compact('order','task')) }}"
                      method="POST"
                      id="cbitem{{ $task->id }}">
                    @csrf
                    {{-- Hidden fields required by EditTask validation --}}
                    <input type="hidden" name="title" value="{{ $task->title }}">
                    <input type="hidden" name="group" value="{{ $task->group }}">
                    <input type="hidden" name="cost"  value="{{ $task->cost }}">
                    <input type="hidden" name="is_done" id="checkInput{{ $task->id }}" value="{{ $task->is_done ? '1' : '0' }}">

                    <p>{{ $task->title }} .......... {{ $task->cost }} DH</p>

                    <input type="checkbox"
                           id="taskCheckbox{{ $task->id }}"
                           onchange="submitTaskStatus({{ $task->id }})"
                           @if($task->is_done) checked @endif>
                </form>
            @endif
        @endforeach
    @endforeach

    <br>

    {{-- ✅ FIX: Formulaire création de facture --}}
    <h2>Facture</h2>

    @if($order->Invoice()->exists())
        @php $invoice = $order->Invoice()->first(); @endphp
        <div style="background:#e8f5e9; padding:15px; border-radius:8px; border:1px solid #a5d6a7;">
            <p>✅ Facture générée</p>
            <p>Sous-total (coût des tâches) : <strong>{{ $order->Tasks()->sum('cost') }} DH</strong></p>
            <p>Remise : <strong>{{ $invoice->discount_percentage }}%</strong></p>
            <p>Frais : <strong>{{ $invoice->fees }} DH</strong></p>
            <p>Total : <strong>{{ $invoice->total_price }} DH</strong></p>
            <p>Statut paiement : <strong>{{ $invoice->payment_status }}</strong></p>
        </div>
    @elseif($order->order_status === 'completed')
        <div class="invoice-form">
            <h3>Générer la Facture</h3>
            <p>Sous-total (coût des tâches) : <strong>{{ $order->Tasks()->sum('cost') }} DH</strong></p>
            <form method="POST" action="{{ route('storeInvoice', $order) }}">
                @csrf
                <div>
                    <label>Remise (%) :</label>
                    <input type="number" name="discount_percentage" value="0" min="0" max="100" step="0.1">
                </div>
                <div>
                    <label>Frais additionnels (DH) :</label>
                    <input type="number" name="fees" value="0" min="0" step="0.01">
                </div>
                <br>
                <button type="submit">✅ Générer la Facture</button>
            </form>
        </div>
    @else
        <p style="color:gray;">⚠️ La facture sera disponible une fois la commande complétée.</p>
    @endif

    <br>
    <h3 class="db-h3">Liste de Produits</h3>

    <div class="prod-list">
        <table class="prod-list-t">
            <thead>
                <tr>
                    <th></th><th>Type</th><th>Nom</th><th>Catégorie</th><th>Qté</th><th>Option</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderList as $item)
                    @php
                        $product = $item->Product($item->prod_category)->first();
                        if ($product) {
                            $img = $product->prod_images()->first();
                            if ($item->prod_category === 'course') {
                                $imgSrc = $img ? asset('images/' . $img->path) : asset('pre_assets/img/empty-img.png');
                            } elseif ($item->prod_category === 'hardware') {
                                $imgSrc = $img ? (str_contains($img->path, '/') ? asset('storage/' . $img->path) : asset('images/products/' . $img->path)) : asset('pre_assets/img/empty-img.png');
                            } else {
                                $imgSrc = $img ? asset('images/products/' . $img->path) : asset('pre_assets/img/empty-img.png');
                            }
                        } else {
                            $imgSrc = asset('pre_assets/img/empty-img.png');
                        }
                    @endphp
                    @if ($product)
                    <tr class="prod-item">
                        <td><img src="{{ $imgSrc }}" alt="{{ $product->name }}"></td>
                        <td>
                            @switch($item->prod_category)
                                @case('hardware') Matériel  @break
                                @case('software') Logiciel  @break
                                @case('service')  Service   @break
                                @case('course')   Formation @break
                            @endswitch
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category ?? '-' }}</td>
                        <td>{{ $item->volume }}</td>
                        <td class="option">
                            <a class="btn" href="{{ url('cp/'.$item->prod_category.'s?search='.$product->name) }}">
                                Afficher
                            </a>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script>
    function submitTaskStatus(taskId) {
        const checked = document.getElementById('taskCheckbox' + taskId).checked;
        document.getElementById('checkInput' + taskId).value = checked ? '1' : '0';
        document.getElementById('cbitem' + taskId).submit();
    }
</script>

@endsection