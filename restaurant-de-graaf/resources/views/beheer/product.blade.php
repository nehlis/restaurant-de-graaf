@extends('layouts.app')

@section('title', 'Beheer | Restaurant de Graaf')
<?php use App\Subtype; ?>
@section('content')
    <div class="beheer container">
        <h1 class="beheer__heading">Productenoverzicht</h1>

        <table class="table table-hover">
            <tr>
                <th>Naam</th>
                <th>Prijs</th>
                <th>Gerechttype</th>
                <th></th>
            </tr>
            @foreach($products as $product)
                <tr>
                    <td class="{{$product->enabled == 0 ? 'disabled' : ''}}">{{$product->name}}</td>
                    <td class="{{$product->enabled == 0 ? 'disabled' : ''}}">{{$product->price}}</td>
                    <td class="{{$product->enabled == 0 ? 'disabled' : ''}}">{{Subtype::where('id', $product->subtype)->get()[0]->name}}</td>
                    <td>

                        <a href="/beheer/producten/{{$product->id}}" class="button button--primary button--primary--small"><i class="fas fa-edit" aria-hidden="true"></i></a>


                        @if($product->enabled == 1)
                            <form method="POST" style="display: inline">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <input type="hidden" name="id" value="{{$product->id}}">
                                <input type="hidden" name="enabled" value="{{$product->enabled}}">
                                <button type="submit" class="button button--danger" title="Deactiveren">
                                    <i class="fas fa-trash-alt"></i></button>
                            </form>
                        @else
                            <form method="POST" style="display: inline">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <input type="hidden" name="id" value="{{$product->id}}">
                                <input type="hidden" name="enabled" value="{{$product->enabled}}">
                                <button type="submit" class="button button--positive" title="Toevoegen">
                                    <i class="fas fa-plus"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
