@extends('user.user-dashboard')

@section('section-content')

<div class="account-container">

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert-success">
            ✔ {{ session('success') }}
        </div>
    @endif

    <!-- ===== EMAIL ===== -->
    <div class="card">
        <h3>Email</h3>

        <form action="{{route('updateUserEmail')}}" method="POST">
            @csrf

            <input id="emailInput" type="email" name="email" value="{{$user->email}}" readonly>

            <button type="submit" id="mailSave" class="btn save">Sauvegarder</button>
        </form>

        <button id="mailEditBtn" class="btn edit">Modifier</button>
    </div>

    <!-- ===== PASSWORD ===== -->
    <div class="card">
        <h3>Mot de passe</h3>

        <form action="{{route('updateUserPassword')}}" method="POST">
            @csrf

            <input type="password" name="old_password" placeholder="Ancien mot de passe" readonly>
            <input type="password" name="new_password" placeholder="Nouveau mot de passe" readonly>

            <button type="submit" id="pwSave" class="btn save">Sauvegarder</button>
        </form>

        <button id="pwEditBtn" class="btn edit">Modifier</button>
    </div>

    <!-- ===== INFOS ===== -->
    <div class="card">
        <h3>Informations</h3>

        <form action="{{route('updateUserInfo')}}" method="POST">
            @csrf

            <div class="grid">
                <input type="text" name="fname" value="{{$user->fname}}" readonly>
                <input type="text" name="lname" value="{{$user->lname}}" readonly>
                <input type="text" name="company" value="{{$user->company}}" readonly>
                <input type="text" name="city" value="{{$user->city}}" readonly>
                <input type="number" name="zip" value="{{$user->zip}}" readonly>
                <input type="text" name="phone" value="{{$user->phone}}" readonly>
            </div>

            <button type="submit" id="genSave" class="btn save">Sauvegarder</button>
        </form>

        <button id="genEditBtn" class="btn edit">Modifier</button>
    </div>

</div>

{{-- ================= STYLE ================= --}}
<style>
.account-container {
    max-width: 800px;
    margin: auto;
    padding: 20px;
}

/* CARD */
.card {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.card h3 {
    margin-bottom: 15px;
    color: #333;
}

/* INPUT */
.card input {
    width: 100%;
    padding: 12px;
    margin-bottom: 10px;
    border-radius: 8px;
    border: 1px solid #ddd;
    transition: 0.3s;
}

.card input:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0,123,255,0.3);
    outline: none;
}

/* GRID */
.grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

/* BUTTONS */
.btn {
    padding: 10px 15px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: 0.3s;
    margin-top: 10px;
}

.edit {
    background: #011030;
    color: #bed8e0;
}

.edit:hover {
    background: #250374;
}

.save {
    background: #1f9caa;
    color: white;
}

.save:hover {
    background: #40626f;
}

/* ALERT */
.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 20px;
}
</style>

{{-- ================= JS ================= --}}
<script>
    // EMAIL
    const emailInput = document.getElementById('emailInput');
    const mailEditBtn = document.getElementById('mailEditBtn');
    const mailSave = document.getElementById('mailSave');

    mailSave.style.display = 'none';

    mailEditBtn.onclick = () => {
        emailInput.removeAttribute('readonly');
        mailSave.style.display = 'inline-block';
        mailEditBtn.style.display = 'none';
    };

    // PASSWORD
    const pwInputs = document.querySelectorAll('.card:nth-child(2) input');
    const pwEditBtn = document.getElementById('pwEditBtn');
    const pwSave = document.getElementById('pwSave');

    pwSave.style.display = 'none';

    pwEditBtn.onclick = () => {
        pwInputs.forEach(i => i.removeAttribute('readonly'));
        pwSave.style.display = 'inline-block';
        pwEditBtn.style.display = 'none';
    };

    // INFOS
    const genInputs = document.querySelectorAll('.grid input');
    const genEditBtn = document.getElementById('genEditBtn');
    const genSave = document.getElementById('genSave');

    genSave.style.display = 'none';

    genEditBtn.onclick = () => {
        genInputs.forEach(i => i.removeAttribute('readonly'));
        genSave.style.display = 'inline-block';
        genEditBtn.style.display = 'none';
    };
</script>

@endsection