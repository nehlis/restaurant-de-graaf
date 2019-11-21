@extends('layouts.app')

@section('title', 'Profiel | Restaurant de Graaf')

@section('content')
    <div class="profiel container">
        <h1 class="profiel__heading">Profiel</h1>
        <div class="card profiel__card">
            <form method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="row">
                    <div class="col-md-6 profiel__input">
                        <label for="input-name">Naam: </label>
                        <input type="text" id="input-name" class="form-control" name="name" required="required" value="{{$user->name}}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-6 profiel__input">
                        <label for="input-street">Straatnaam: </label>
                        <input type="text" id="input-street" class="form-control" name="street" value="{{$user->street}}">
                        @error('street')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 profiel__input">
                        <label for="input-tel_number">Telefoonnummer: </label>
                        <input type="tel" id="input-tel_number" class="form-control" name="tel_number" required="required" value="{{$user->tel_number}}">
                        @error('tel_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-6 profiel__input">
                        <label for="input-house_number">Huisnummer: </label>
                        <input type="number" id="input-house_number" class="form-control" name="house_number" value="{{$user->house_number}}">
                        @error('house_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 profiel__input">
                        <label for="input-email">Emailadres: </label>
                        <input type="email" id="input-email" class="form-control" name="email" required="required" value="{{$user->email}}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-6 profiel__input">
                        <label for="input-city">Woonplaats: </label>
                        <input type="text" id="input-city" class="form-control" name="city" value="{{$user->city}}">
                        @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 profiel__input">
                        <label for="input-zipcode">Postcode: </label>
                        <input type="text" id="input-zipcode" class="form-control" name="zipcode" value="{{$user->zipcode}}">
                        @error('zipcode')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-6 profiel__spacing">
                        <button type="submit" class="button float-right button--primary">Wijzigen</button>
                        <a href="/"><button type="button" class="button button--danger float-right">Account opzeggen</button></a>
                    </div>
                </div>
            </form>
            @if(isset($putSucces))
                @if($putSucces == true)
                    <div class="alert alert-success reservation__alert" role="alert">
                        Je gegevens zijn succesvol gewijzigd!
                        <button type="button" class="close reservation__alert-close">
                            <span>&times;</span>
                        </button>
                    </div>
                @endif
            @endif
        </div>
        <div id="registraties">
            <h2>Reserveringen</h2>
            @foreach($reservations as $reservation)
                <div class="card profiel__card profiel__card--less-margin">
                    <h3>{{$reservation->reservation_code}}</h3>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-3"><b>Datum:</b> {{date("Y-m-d", strtotime($reservation->date))}}</div>
                                <div class="col-md-2">
                                    <b>Tafelnummers:</b>
                                    @foreach($tables_reservations as $table)
                                        @if($table->reservation_code == $reservation->reservation_code)
                                            {{$loop->first ? '' : ', '}}
                                            {{$table->table_id}}
                                        @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2"><b>Tijd:</b> {{date("H:i", strtotime($reservation->date))}}</div>
                                <div class="col-md-3"><b>Duur:</b> {{$reservation->duration}} minuten</div>
                                <div class="col-md-2"><b>Personen:</b> {{$reservation->guest_amount}}</div>
                            </div>
                        </div>
                        <div class="col-md-2 float-right">
                            @if(new DateTime($reservation->date) <= new DateTime(date("Y-m-d H:i:s")))
                                <a href="#">Nota downloaden</a>
                            @else
                                <a href="/"><button type="button" class="button button--danger float-right">Annuleren</button></a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

{{--            <div class="card">--}}
{{--                <h3>20200107051</h3>--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-3"><b>Datum:</b> Dinsdag 7 Januari 2020</div>--}}
{{--                    <div class="col-md-2"><b>Tafelnummers:</b> 7</div>--}}
{{--                    <div class="col-md-1"><b>Tijd:</b> 18:00</div>--}}
{{--                    <div class="col-md-1"><b>Duur:</b> 2 uur</div>--}}
{{--                    <div class="col-md-2"><b>Personen:</b> 3</div>--}}
{{--                    <div class="col-md-3 float-right"><a href="#">Nota downloaden</a></div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
@endsection
