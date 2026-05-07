@extends('user.user-dashboard')

@section('section-content')

<style>
/* ===== Ticket Container ===== */
.ticket-wrapper {
    max-width: 700px;
    margin: 20px auto 30px auto; /* top 20px (mqarrab lfo9) */
    padding: 30px 40px;
    background: #ffffff; 
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(162, 3, 3, 0.1);
    color: #333;
    font-family: 'Segoe UI', sans-serif;
    position: relative;
    z-index: 2;
    transition: all 0.3s ease;
}

/* Spacing from sidebar */
@media(min-width: 1200px){
    .ticket-wrapper {
        margin-left: 300px; /* space for sidebar */
    }
}
/* ===== Form Elements ===== */
.ticket-wrapper form input,
.ticket-wrapper form textarea,
.ticket-wrapper form select {
    width: 100%;
    padding: 15px 12px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background: #f7f9fc;
    color: #333;
    font-size: 1rem;
    outline: none;
    transition: 0.3s all;
}

.ticket-wrapper form input:focus,
.ticket-wrapper form textarea:focus,
.ticket-wrapper form select:focus {
    border-color: #010e22;
    box-shadow: 0 0 10px rgba(2, 28, 74, 0.25);
    background: #fff;
}

/* ===== Buttons ===== */
.ticket-wrapper form button {
    background: #011c4a;
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s all;
}

.ticket-wrapper form button:hover {
    background: #2b0202;
    transform: scale(1.05);
    box-shadow: 0 0 12px rgba(34, 1, 1, 0.35);
}

/* ===== Custom Select ===== */
.custom-select {
    position: relative;
    font-family: 'Segoe UI', sans-serif;
}

.select-selected {
    background-color: #f7f9fc;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 15px 12px;
    cursor: pointer;
    user-select: none;
}

.select-items div {
    padding: 10px 15px;
    cursor: pointer;
    background-color: #fff;
    border-bottom: 1px solid #eee;
}

.select-items div:hover {
    background-color: #f0f4ff;
}

.select-hide {
    display: none;
}

.select-arrow-active {
    border-color: transparent transparent #1f468b transparent;
}

/* ===== Spacing from sidebar ===== */
@media(min-width: 1000px){
    .ticket-wrapper {
        margin-left: 25px; /* space for sidebar */
    }
}

/* ===== Responsive ===== */
@media(max-width: 1199px){
    .ticket-wrapper {
        margin-left: 20px;
        margin-right: 20px;
    }
}

@media(max-width:768px){
    .ticket-wrapper {
        width: 95%;
        padding: 20px;
    }
}
</style>

<div class="input-section ticket-wrapper">
<form action="{{route('newTicket')}}" method="POST">
    @csrf

    <input type="text" name="title" placeholder="Title">

    <textarea name="description" placeholder="Description"></textarea>

    <select name="type">
        <option value="question">Question</option>
        <option value="help">Assistance</option>
        <option value="issue">Problème</option>
    </select>

    <button type="submit">Submit Ticket</button>
</form>
</div>

<script>
    // Custom select JS
    var x, i, j, l, ll, selElmnt, a, b, c;
    x = document.getElementsByClassName("custom-select");
    l = x.length;
    for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;

        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);

        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");

        for (j = 1; j < ll; j++) {
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function(e) {
                var s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                var h = this.parentNode.previousSibling;
                for (var i = 0; i < s.length; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        var y = this.parentNode.getElementsByClassName("same-as-selected");
                        for (var k = 0; k < y.length; k++) { y[k].removeAttribute("class"); }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);

        a.addEventListener("click", function(e) {
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }

    function closeAllSelect(elmnt) {
        var x = document.getElementsByClassName("select-items");
        var y = document.getElementsByClassName("select-selected");
        for (var i = 0; i < y.length; i++) {
            if (elmnt != y[i]) y[i].classList.remove("select-arrow-active");
        }
        for (var i = 0; i < x.length; i++) {
            if (!x[i].classList.contains("select-hide")) x[i].classList.add("select-hide");
        }
    }
    document.addEventListener("click", closeAllSelect);
</script>

@endsection