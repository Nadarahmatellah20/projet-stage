<head>
    <link rel="stylesheet" href="{{ URL::asset('style/orders-style.css')}}">

    <script>
        
        
        function showMore(){
            const elm = document.querySelector('.status-details');
            elm.style.display = 'block';
        }

        function closeMore(){
            const elm = document.querySelector('.status-details');
            elm.style.display = 'none';
        }
    </script>
</head>
      
      

@extends('user.user-dashboard')

@section('section-content')
<div class="wrapper-show">


    <div class="order-header">
        <h2>{{$order->title}}</h2>
        <p class="created_at">{{$order->created_at}}</p>
    </div>
    <br>
    <p class="order-status">Statut:
        <span class="{{$order->order_status}}">
            @switch($order->order_status)
                @case('pending')
                    en attente
                    @break
                @case('delivering')
                    en livraison
                    @break
                @case('completed')
                    terminé
                    @break
                @default
                    ...
            @endswitch
        </span>

    </p>
    @if ($order->order_status == 'completed')
        <br><a href="{{route('displayInvoice', $order)}}">Afficher la Facture</a>
    @endif
    <div class="description">
        <br><h3 class="db-h3">Description: </h3><br>
        @php
            echo $order->description;
        @endphp
    </div>

    <br><h3 class="db-h3">Statut</h3>
    <div class="order-status">

        <div class="progress">
            <div id="myBar" class="bar" style="width:10%" >0</div>
        </div>

        <button id="showDetails" onclick="showMore()" class="details-btn">Afficher Les Details</button>

        <script defer>
            
            initPB({{$order->status}});
            function initPB(maxValue) {
            var elem = document.getElementById("myBar");
            var id = setInterval(frame, 15);
            var width = 0;
            function frame() {
            if (width >= 100) {
                clearInterval(id);
            } else {
                if(width < maxValue)
                {
                    width++; 
                    elem.style.width = width + '%'; 
                    elem.innerHTML = width * 1  + '%';
                }
            }
            }
        }
        </script>
    </div>

    <div class="status-details" style="">
        <div class="status-container">

            <div class="status-header">
                <h3 class="db-h3">Taches</h3>
                <span onclick="closeMore()">&times;</span>
            </div>
            <div class="status-content">
    
                @foreach ($taskGroups as $group)
                    <h4 class="task-group">{{$group}}</h4>
                    @foreach ($tasks as $task)
                        @if ($task->group == $group)
                        <div class="task-item">
                            <p class="task-title">{{$task->title}}</p>
                            <div class="line"></div>
                            @if ($task->is_done)
                                <p class="status">Complété</p>
                            @else
                                <p class="status">En Attend</p>
                            @endif
                        </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>

        
    </div>

    <br><h3 class="db-h3">Liste de Produits</h3>
    <div class="prod-list">
        <table class='prod-list-t'>
            <thead>
                <tr>
                    <th></th>
                    <th>Type</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Qté</th>
                    <th>Option</th>
                </tr>
            </thead>
      <tbody>
@foreach ($orderList as $item)

@php
$product = null;

if(method_exists($item,'Product')){
    $query = $item->Product($item->prod_category);
    if($query){
        $product = $query->first();
    }
}
@endphp

@if($product)

@php
$img = $product->prod_images()->get();
$imgPath = count($img) ? $img[0]->path : 'pre_assets/img/empty-img.png';
@endphp

<tr class="prod-item">

<td>
<img src="{{ URL::asset('storage/' . $imgPath) }}" alt="">
</td>

<td>
@switch($product->prod_category)
    @case('software')
        Logiciel
        @break
    @case('hardware')
        Matériel
        @break
    @case('service')
        Service
        @break
    @case('course')
        Formation
        @break
@endswitch
</td>

<td>{{$product->name}}</td>

<td>{{$product->category}}</td>

<td>
@if ($product->prod_category == 'service')
-
@else
{{$item->volume}}
@endif
</td>

<td class="option">
    —
</td>

</tr>

@endif

@endforeach
</tbody>
        </table>
    </div>

</div>
@endsection