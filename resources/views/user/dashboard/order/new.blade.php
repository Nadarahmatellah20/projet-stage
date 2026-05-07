@extends('user.user-dashboard')

@section('section-content')

<style>
/* ===== Container layout ===== */
.order-container {

    max-width: 700px;
    margin: 20px auto 30px auto; /* top 20px (mqarrab lfo9) */
    padding: 30px 40px;
    background: #ffffff; 
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    color: #333;
    font-family: 'Segoe UI', sans-serif;
    position: relative;
    z-index: 2;
    transition: all 0.3s ease;
}

/* ===== Headings ===== */
.order-container h3 {
    color: #04132e;
    font-size: 2rem;
    margin-bottom: 25px;
    letter-spacing: 0.5px;
}

/* ===== Inputs ===== */
.order-input,
.order-text {
    width: 100%;
    padding: 15px 12px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background: #f7f9fc;
    color: #333;
    outline: none;
    font-size: 1rem;
    transition: 0.3s all;
}

.order-input:focus,
.order-text:focus {
    border-color: #031b45;
    box-shadow: 0 0 10px rgba(31,70,139,0.25);
    background: #fff;
}

/* ===== Buttons ===== */
.order-btn,
.send-btn,
.option .btn,
.prod-list td a.btn {
    background: #021331;
    color: white;
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s all;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
}

.order-btn:hover,
.send-btn:hover,
.option .btn:hover,
.prod-list td a.btn:hover {
    background: #430505;
    transform: scale(1.05);
    box-shadow: 0 0 12px rgba(255,59,59,0.35);
}

/* ===== Table ===== */
.products-table,
.prod-list-t {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
    font-family: Arial, sans-serif;
    border-radius: 10px;
    overflow: hidden;
}

.products-table th,
.prod-list-t th {
    background: #031a40;
    color: white;
    padding: 12px;
    text-align: left;
    font-size: 1rem;
}

.products-table td,
.prod-list-t td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    font-size: 0.95rem;
}

.products-table tr:hover,
.prod-list-t tr:hover {
    background: #f0f4ff;
}

/* ===== Remove button ===== */
.remove-btn {
    background: #530f08;
    color: white;
    padding: 6px 14px;
    border-radius: 5px;
    font-size: 13px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.remove-btn:hover {
    background: #520c04;
    transform: scale(1.1);
}

/* ===== Spacing from sidebar ===== */
@media(min-width: 1000px){
    .order-container {
        margin-left: 25px; /* leave space for sidebar */
    }
}

/* ===== Responsive ===== */
@media(max-width: 1199px){
    .order-container {
        margin-left: 20px;
        margin-right: 20px;
    }
}

@media(max-width:768px){
    .order-container {
        width: 95%;
        padding: 20px;
    }
    .order-input,
    .order-text {
        width: 100%;
    }
    .products-table,
    .prod-list-t {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
}

</style>

<div class="order-container">

    <h3>Send New Order</h3>

    <form action="{{route('newOrder')}}" method="post">
        @csrf
        <input type="text" name="title" placeholder="Titre" class="order-input">
        <br>
        <textarea name="description" class="order-text" placeholder="Description"></textarea>
        <br>
        <button type="submit" class="order-btn">Send</button>
    </form>

    <h3>Liste de Produits</h3>

    <table class="products-table">
        <tr>
            <th>Type</th>
            <th>Nom</th>
            <th>Qté</th>
            <th>Option</th>
        </tr>

        @foreach($orderList as $item)
            @php
                $product = null;
                if($item->prod_category=="software"){
                    $product=DB::table('softwares')->where('id',$item->prod_id)->first();
                }elseif($item->prod_category=="hardware"){
                    $product=DB::table('hardwares')->where('id',$item->prod_id)->first();
                }elseif($item->prod_category=="service"){
                    $product=DB::table('services')->where('id',$item->prod_id)->first();
                }elseif($item->prod_category=="course"){
                    $product=DB::table('courses')->where('id',$item->prod_id)->first();
                }
            @endphp

            @if($product)
            <tr>
                <td>{{$item->prod_category}}</td>
                <td>{{$product->name ?? 'product'}}</td>
                <td>{{$item->volume}}</td>
                <td>
                    <a href="{{route('removeProductFromList',$item)}}" class="remove-btn">Remove</a>
                </td>
            </tr>
            @endif
        @endforeach
    </table>

</div>

@endsection